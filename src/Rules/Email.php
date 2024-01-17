<?php declare(strict_types=1);

namespace Valid8\Rules;

class Email implements Rule
{
    protected string $field;
    protected string $message;

    public function validate(string $field, mixed $data, string $message = null): bool
    {
        $this->field = $field;
        $this->message = is_null($message) ? '{field} must be a email.' : $message;

        if (! is_string($data)) {
            return false;
        }

        $partsOfEmail = array_filter(explode('@', $data));

        if (count($partsOfEmail) != 2) {
            return false;
        }

        $partsOfDomain = array_filter(explode('.', $partsOfEmail[1]));

        if (count($partsOfDomain) != 2) {
            return false;
        }

        $domainName = $partsOfDomain[0];
        $tld = $partsOfDomain[1];

        $domainStartsWithHyphen = str_starts_with($domainName, '-');
        $domainEndsWithHyphen = str_ends_with($domainName, '-');
        $domainLengthIsValid = (strlen($domainName) <= 63) && (strlen($domainName) >= 1);
        $tldLengthIsValid = (strlen($tld) <= 6) && (strlen($tld) >= 2);

        if ($domainStartsWithHyphen || $domainEndsWithHyphen || (!$domainLengthIsValid) || (!$tldLengthIsValid))
        {
            return false;
        }

        return true;
    }

    public function error(): string
    {
        return str_replace('{field}', $this->field, $this->message);
    }
}