<?php

namespace Whitecube\LaravelCookieConsent;

class Cookie
{
    use Concerns\HasAttributes;
    use Concerns\HasConsentCallback;

    /**
     * The cookie's name.
     */
    public readonly string $name;

    /**
     * The cookie's duration.
     */
    public readonly int $duration;

    /**
     * Set the cookie's name.
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the cookie's duration in minutes.
     */
    public function duration(int $minutes): static
    {
        $this->duration = $minutes;

        return $this;
    }

    /**
     * Get the cookie's duration as human-readable text.
     */
    public function getFormattedDuration(): string
    {
        $factors = \Carbon\CarbonInterval::getCascadeFactors();
        $factors['years'] = [365, 'dayz'];
        \Carbon\CarbonInterval::setCascadeFactors($factors);

        $formatted = \Carbon\CarbonInterval::minutes($this->duration)->cascade();

        // Reset cascade factors to defaults
        \Carbon\CarbonInterval::setCascadeFactors(\Carbon\CarbonInterval::getDefaultCascadeFactors());

        return $formatted;
    }

    /**
     * Set an attribute dynamically.
     */
    public function __call(string $method, array $arguments): static
    {
        $this->setAttribute($method, $arguments[0] ?? null);

        return $this;
    }
}
