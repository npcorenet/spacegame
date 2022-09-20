<?php
declare(strict_types=1);

namespace App\Model;

use DateTime;

abstract class AbstractModel
{

    public function generateArrayFromSetVariables(): array
    {
        $data = [];

        foreach (get_object_vars($this) as $var => $value)
        {
            if(!is_null($var)) {
                $data[$var] = $value;
                if($data[$var] instanceof DateTime)
                {
                    $data[$var] = $data[$var]->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']);
                }
            }
        }

        return $data;
    }

    public function clear(): void
    {
        foreach ($this as $var => $value)
        {
            unset($this->$var);
        }
    }

    public function fillFromArray(array $data): self
    {
        $vars = [];

        foreach (get_class_vars(get_class($this)) as $var => $value)
        {
            $vars = array_merge($vars, [$var]);
        }

        foreach ($data as $var => $value)
        {
            if(in_array($var, $vars))
            {
                if(is_string($value) && DateTime::createFromFormat($_ENV['SOFTWARE_FORMAT_TIMESTAMP'], $value) !== FALSE)
                {
                    $this->$var = new DateTime($value, new \DateTimeZone($_ENV['SOFTWARE_TIMEZONE']));
                    continue;
                }

                $this->$var = $value;
            }
        }

        return $this;
    }

}
