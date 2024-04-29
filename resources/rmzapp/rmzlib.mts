/*
 *  The Roomz UI Library
 */


//  Types

export type JSON = Record<string, any>;

export type HttpMethod = 'get' | 'post' | 'put' | 'patch' | 'delete';

export type HttpResponse = {
    success: number,
    data?: JSON,
    dbg?: JSON,
    error?: string,
}

export type EmitterFunc = (data: JSON) => Promise<any>;

export interface ApiOptions {
    path: string,
    method?: HttpMethod,
    headers?: JSON,
    query?: JSON,
    body?: string,
    auth?: string,
    bearer?: string,
    onresponse?: ApiCallback,
    onsuccess?: ApiCallback,
    onfail?: ApiCallback,
}

export interface EmitterSub {
    event: string,
    func: EmitterFunc,
}


// Classes

export class Emitter {
    public subs: EmitterSub[] = [];

    public emit(event: string, data: JSON = {}): void {
        let newData: JSON = {event, ...data};

        for (let sub of this.subs)
            if ([event, '_all'].includes(sub.event))
                sub.func(newData).catch(err);
    }

    public on(event: string, func: EmitterFunc): void {
        this.subs.push({event, func});
    }
}

export class Events {
    public static emitter: Emitter = new Emitter();

    public static emit(event: string, data: JSON = {}): void {
        this.emitter.emit(event, data);
    }

    public static on(event: string, func: EmitterFunc): void {
        this.emitter.on(event, func);
    }
}

export class RmzError extends Error {
    constructor(message: string, stack?: string) {
        super(message);
        if (stack) this.stack = stack;
    }
}


// Functions

export function error(message: string, stack?: string): RmzError {
    throw new RmzError(message, stack);
}

export function err(e: any): void {
    throw error(e.message, e.stack);
}

export function env<S extends boolean>(name: string, strict: S = true): S extends true ? string : string|null {
    const result = process.env[name.toUpperCase()] ?? null;
    if (strict && !result) throw error(`Env: Cannot get '${name}'`);
    return result;
}

export function querify(json: JSON, prefix: string = '', depth: number = 10): string {
    if (depth <= 0) throw error('Querify: The JSON is too deep');

    let result = '';

    for (const key in json) {
        if (!json.hasOwnProperty(key)) continue;

        const value = json[key];
        const newKey = prefix ? `${prefix}[${key}]` : key;

        if (typeof value === 'object' && value !== null)
            result += `&${querify(value, newKey, depth-1)}`;
        else
            result += `&${newKey}=${encodeURIComponent(value)}`;
    }

    // Removing the first '&'
    result = result.slice(1);

    return result;
}

export async function api(options: ApiOptions): Promise<HttpResponse> {
    const fetchOptions: JSON = {};
    let fetchUrl = options.path;

    const header = (name: string, value: string) => options.headers[name] = value;


    // Working with the HTTP method

    fetchOptions.method = options.method ?? 'get';
    const isGet = fetchOptions.method === 'get';
    const isPost = fetchOptions.method === 'post';


    // Working with the headers

    if (options.auth) header('Authorization', 'Bearer '+options.bearer);
    if (options.bearer) header('Authorization', 'Bearer '+options.bearer);
    fetchOptions.headers = options.headers;


    // Working with the query

    if (options.query && isGet)
        fetchUrl += '?'+querify(options.query);
    if (options.query && isPost)
        fetchOptions.body = querify(options.query);
    if (options.body && isPost)
        fetchOptions.body = options.body;


    // Fetching the response

    const response = await fetch(fetchUrl, fetchOptions);
    let responseJSON: HttpResponse;


    // Parsing the response

    try {responseJSON = await response.json() as HttpResponse;}
    catch (e) {throw error(`Error parsing the API response: ${e.message}`, e.stack);}


    // Calling the callbacks

    if (options.onresponse) options.onresponse(responseJSON);
    if (responseJSON.success && options.onsuccess) options.onsuccess(responseJSON);
    if (!responseJSON.success && options.onfail) options.onfail(responseJSON);


    return responseJSON;
}
