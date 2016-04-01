<?php

namespace Lce\Exception;

use Lce\Exception\AccessDeniedException;
use Lce\Exception\AccountDisabledException;

class LceException extends \Exception
{
    public static function build($uri, $response)
    {
        $message = $uri.' | ';
        if (property_exists($response->body, 'error')) {
            $error = $response->body->error;
            $message .= $error->message;
            if (isset($error->details) && !empty($error->details)) {
                $message .= ' '.implode(' ', $error->details);
            }
            $type = $error->type;
        } else {
            $message .= 'Unknown Error. Are you using the correct server ? protocol ? port ? : '.strtok($response->raw_headers, "\n");
            $type = 'unknown';
        }
        switch ($type) {
      case 'access_denied':
        return new AccessDeniedException($message);
        break;
      case 'account_disabled':
        return new AccountDisabledException($message);
        break;
      default:
       return new self($message);
    }
    }
}
