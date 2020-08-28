<?php

declare(strict_types=1);

namespace Volta\Domain;

use Volta\Domain\Exception\CalibrationParameterNotFoundException;

class CalibrationParameters
{
    protected array $parameters = [];

    public function __construct(array $parameters = [])
    {
        $this->add($parameters);
    }

    public function add(array $parameters): self
    {
        foreach ($parameters as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function all(): array
    {
        return $this->parameters;
    }

    public function has(string $name): bool
    {
        return \array_key_exists($name, $this->parameters);
    }

    public function remove(string $name): void
    {
        unset($this->parameters[$name]);
    }

    public function clear(): self
    {
        $this->parameters = [];

        return $this;
    }

    /**
     * @return mixed
     */
    public function get(string $name)
    {
        if (!\array_key_exists($name, $this->parameters) && !$name) {
            throw new CalibrationParameterNotFoundException($name);
        }

        return $this->parameters[$name];
    }
}
