<?php namespace Motokraft\MCPServer\Http;

/**
 * @copyright 2025 MCP Server (Eurospeckam)
 * @license MIT License AND Apache License 2.0
 * @link https://github.com/motokraft/mcp-server
 */

final class StatusCode
{
    /**
     * The response status for "Continue"
     *
     * @var int
     */
    const Status100Continue = 100;

    /**
     * The response status for "Switching Protocols"
     *
     * @var int
     */
    const Status101SwitchingProtocols = 101;

    /**
     * The response status for "Processing"
     *
     * @var int
     */
    const Status102Processing = 102;

    /**
     * The response status for "OK"
     *
     * @var int
     */
    const Status200OK = 200;

    /**
     * The response status for "Created"
     *
     * @var int
     */
    const Status201Created = 201;

    /**
     * The response status for "Accepted"
     *
     * @var int
     */
    const Status202Accepted = 202;

    /**
     * The response status for "Non-Authoritative Information"
     *
     * @var int
     */
    const Status203NonAuthoritative = 203;

    /**
     * The response status for "No Content"
     *
     * @var int
     */
    const Status204NoContent = 204;

    /**
     * The response status for "Reset Content"
     *
     * @var int
     */
    const Status205ResetContent = 205;

    /**
     * The response status for "Partial Content"
     *
     * @var int
     */
    const Status206PartialContent = 206;

    /**
     * The response status for "Multi-Status"
     *
     * @var int
     */
    const Status207MultiStatus = 207;

    /**
     * The response status for "Already Reported"
     *
     * @var int
     */
    const Status208AlreadyReported = 208;

    /**
     * The response status for "IM Used"
     *
     * @var int
     */
    const Status226IMUsed = 226;

    /**
     * The response status for "Multiple Choices"
     *
     * @var int
     */
    const Status300MultipleChoices = 300;

    /**
     * The response status for "Moved Permanently"
     *
     * @var int
     */
    const Status301MovedPermanently = 301;

    /**
     * The response status for "Found"
     *
     * @var int
     */
    const Status302Found = 302;

    /**
     * The response status for "See Other"
     *
     * @var int
     */
    const Status303SeeOther = 303;

    /**
     * The response status for "Not Modified"
     *
     * @var int
     */
    const Status304NotModified = 304;

    /**
     * The response status for "Use Proxy"
     *
     * @var int
     */
    const Status305UseProxy = 305;

    /**
     * The response status for "Switch Proxy"
     *
     * @var int
     */
    const Status306SwitchProxy = 306;

    /**
     * The response status for "Temporary Redirect"
     *
     * @var int
     */
    const Status307TemporaryRedirect = 307;

    /**
     * The response status for "Permanent Redirect"
     *
     * @var int
     */
    const Status308PermanentRedirect = 308;

    /**
     * The response status for "Bad Request"
     *
     * @var int
     */
    const Status400BadRequest = 400;

    /**
     * The response status for "Unauthorized"
     *
     * @var int
     */
    const Status401Unauthorized = 401;

    /**
     * The response status for "Payment Required"
     *
     * @var int
     */
    const Status402PaymentRequired = 402;

    /**
     * The response status for "Forbidden"
     *
     * @var int
     */
    const Status403Forbidden = 403;

    /**
     * The response status for "Not Found"
     *
     * @var int
     */
    const Status404NotFound = 404;

    /**
     * The response status for "Method Not Allowed"
     *
     * @var int
     */
    const Status405MethodNotAllowed = 405;

    /**
     * The response status for "Not Acceptable"
     *
     * @var int
     */
    const Status406NotAcceptable = 406;

    /**
     * The response status for "Proxy Authentication Required"
     *
     * @var int
     */
    const Status407ProxyAuthenticationRequired = 407;

    /**
     * The response status for "Request Timeout"
     *
     * @var int
     */
    const Status408RequestTimeout = 408;

    /**
     * The response status for "Conflict"
     *
     * @var int
     */
    const Status409Conflict = 409;

    /**
     * The response status for "Gone"
     *
     * @var int
     */
    const Status410Gone = 410;

    /**
     * The response status for "Length Required"
     *
     * @var int
     */
    const Status411LengthRequired = 411;

    /**
     * The response status for "Precondition Failed"
     *
     * @var int
     */
    const Status412PreconditionFailed = 412;

    /**
     * The response status for "Payload Too Large"
     *
     * @var int
     */
    const Status413PayloadTooLarge = 413;

    /**
     * The response status for "Request Entity Too Large"
     *
     * @var int
     */
    const Status413RequestEntityTooLarge = 413;

    /**
     * The response status for "Request URI Too Long"
     *
     * @var int
     */
    const Status414RequestUriTooLong = 414;

    /**
     * The response status for "URI Too Long"
     *
     * @var int
     */
    const Status414UriTooLong = 414;

    /**
     * The response status for "Unsupported Media Type"
     *
     * @var int
     */
    const Status415UnsupportedMediaType = 415;

    /**
     * The response status for "Range Not Satisfiable"
     *
     * @var int
     */
    const Status416RangeNotSatisfiable = 416;

    /**
     * The response status for "Requested Range Not Satisfiable"
     *
     * @var int
     */
    const Status416RequestedRangeNotSatisfiable = 416;

    /**
     * The response status for "Expectation Failed"
     *
     * @var int
     */
    const Status417ExpectationFailed = 417;

    /**
     * The response status for "I'm a Teapot"
     *
     * @var int
     */
    const Status418ImATeapot = 418;

    /**
     * The response status for "Authentication Timeout"
     *
     * @var int
     */
    const Status419AuthenticationTimeout = 419;

    /**
     * The response status for "Misdirected Request"
     *
     * @var int
     */
    const Status421MisdirectedRequest = 421;

    /**
     * The response status for "Unprocessable Entity"
     *
     * @var int
     */
    const Status422UnprocessableEntity = 422;

    /**
     * The response status for "Locked"
     *
     * @var int
     */
    const Status423Locked = 423;

    /**
     * The response status for "Failed Dependency"
     *
     * @var int
     */
    const Status424FailedDependency = 424;

    /**
     * The response status for "Upgrade Required"
     *
     * @var int
     */
    const Status426UpgradeRequired = 426;

    /**
     * The response status for "Precondition Required"
     *
     * @var int
     */
    const Status428PreconditionRequired = 428;

    /**
     * The response status for "Too Many Requests"
     *
     * @var int
     */
    const Status429TooManyRequests = 429;

    /**
     * The response status for "Request Header Fields Too Large"
     *
     * @var int
     */
    const Status431RequestHeaderFieldsTooLarge = 431;

    /**
     * The response status for "Unavailable For Legal Reasons"
     *
     * @var int
     */
    const Status451UnavailableForLegalReasons = 451;

    /**
     * The response status for "Internal Server Error"
     *
     * @var int
     */
    const Status500InternalServerError = 500;

    /**
     * The response status for "Not Implemented"
     *
     * @var int
     */
    const Status501NotImplemented = 501;

    /**
     * The response status for "Bad Gateway"
     *
     * @var int
     */
    const Status502BadGateway = 502;

    /**
     * The response status for "Service Unavailable"
     *
     * @var int
     */
    const Status503ServiceUnavailable = 503;

    /**
     * The response status for "Gateway Timeout"
     *
     * @var int
     */
    const Status504GatewayTimeout = 504;

    /**
     * The response status for "HTTP Version Not Supported"
     *
     * @var int
     */
    const Status505HttpVersionNotsupported = 505;

    /**
     * The response status for "Variant Also Negotiates"
     *
     * @var int
     */
    const Status506VariantAlsoNegotiates = 506;

    /**
     * The response status for "Insufficient Storage"
     *
     * @var int
     */
    const Status507InsufficientStorage = 507;

    /**
     * The response status for "Loop Detected"
     *
     * @var int
     */
    const Status508LoopDetected = 508;

    /**
     * The response status for "Not Extended"
     *
     * @var int
     */
    const Status510NotExtended = 510;

    /**
     * The response status for "Network Authentication Required"
     *
     * @var int
     */
    const Status511NetworkAuthenticationRequired = 511;

    /**
     * Mapping of HTTP status codes to their reason phrases.
     *
     * @var array<int, string>
     */
    private static array $_ResponseMap = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',
		226 => 'IM Used',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Payload Too Large',
		414 => 'URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		421 => 'Misdirected Request',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		451 => 'Unavailable For Legal Reasons',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		510 => 'Not Extended',
		511 => 'Network Authentication Required'
	];

    /**
     * Checks if the provided HTTP status code exists in the response map.
     *
     * @param int $Code The HTTP status code to check.
     *
     * @return bool Returns true if the status code exists; otherwise, false.
     */
	static function HasCode(int $Code) : bool
	{
		return isset(self::$_ResponseMap[$Code]);
	}

    /**
     * Converts the HTTP status code to its corresponding status line.
     *
     * @param int $Code The HTTP status code to convert.
     * @param string $Message
     *
     * @return string Returns the formatted HTTP status line.
     */
	static function GetCodeMessage(int $Code) : bool|string
	{
		if(!self::HasCode($Code)) return false;
        return self::$_ResponseMap[$Code];
	}

    /**
     * Converts the HTTP status code to its corresponding status line.
     *
     * @param int $Code The HTTP status code to convert.
     * @param string $Message The HTTP status code to convert.
     * @param string $Format The HTTP status code to convert.
     *
     * @return string Returns the formatted HTTP status line.
     */
	static function ToString(int $Code, ?string $Message = null, ?string $Format = '%s %s %s') : string
	{
		if(empty($Message) && self::HasCode($Code))
        {
            $Message = self::GetCodeMessage($Code);
        }

		return vsprintf($Format, [
            $_SERVER['SERVER_PROTOCOL'], $Code, $Message
        ]);
	}
}