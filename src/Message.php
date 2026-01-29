<?php

namespace Validation;

class Message
{
    /**
     * The message template.
     *
     * @var string
     */
    protected $template;

    /**
     * The message template replacements.
     *
     * @var array
     */
    protected $replacements;

    /**
     * Constructor.
     *
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * Set a replacement key and value.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setReplacement(string $key, string $value): void
    {
        $this->replacements[$key] = $value;
    }

    /**
     * Build the message.
     *
     * @return string
     */
    public function build(): string
    {
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $this->template
        );
    }
}
