<?php

namespace CrudBuilder\Helpers\Forms;

class Input
{
    /**
     * Available blade component names.
     *
     * @var array
     */
    const TYPES = [
        'text', // This type is applicable for passwords, emails, date, and time
        'select',
        'select-two',
        'file',
        'text-area',
        'text-editor',
        'radios',
        'checkboxes',
        'date-range',
    ];

    /**
     * Input name that will be sent in the request.
     *
     * @var string
     */
    public $name;

    /**
     * Input id attribute.
     *
     * @var [type]
     */
    public $id;

    /**
     * Input label that will be in a label tag.
     *
     * @var string|null
     */
    public $label;

    /**
     * This variable will determine the blade component to be rendered.
     *
     * @var string
     */
    public $type;

    /**
     * The type attribute of the input tag.
     *
     * @var string
     */
    public $textType;

    /**
     * Determine if the input label should be marked as mandatory.
     *
     * @var bool
     */
    public $mandatory;

    /**
     * The help text below the input tag.
     *
     * @var string|null
     */
    public $helpText;

    /**
     * The options of a select tag or select-two tag.
     *
     * @var array
     */
    public $options;

    /**
     * Determine if the user can add new options.
     *
     * @var bool
     */
    public $taggable;

    /**
     * The placeholder for input tag.
     *
     * @var string|null
     */
    public $placeholder;

    /**
     * Determines if the input is disabled.
     *
     * @var bool
     */
    public $disabled;

    /**
     * Determines if the input is readonly.
     *
     * @var bool
     */
    public $readonly;

    public function __construct(
        string $name,
        string $id = null,
        string $type,
        string $textType = null,
        string $label = null,
        string $placeholder = null,
        array $options = [],
        bool $taggable = false,
        bool $mandatory = true,
        string $helpText = null,
        bool $disabled = false,
        bool $readonly = false
    ) {
        if (! in_array($type, self::TYPES)) {
            throw new \Exception('There is no input with the supplied type.', 500);
        }

        $this->name = $name;
        $this->id = $id;
        $this->type = $type;
        $this->textType = $textType;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->taggable = $taggable;
        $this->mandatory = $mandatory;
        $this->helpText = $helpText;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
    }
}
