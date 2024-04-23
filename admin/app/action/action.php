<?php

class Action
{
    protected $action;
    protected $data;

    public function __construct(iterable $userdata)
    {
        $this->action = htmlspecialchars($userdata["action"]);
        $this->data = [];
        foreach ($userdata as $key => $value) {
            if ($key === "action")
                continue;

            $this->data[$key] = htmlspecialchars($value);
        }
    }

    public function run(string $action, callable $function)
    {
        if ($action !== $this->action) {
            return;
        }
        call_user_func($function, $this->data);
        // $class->$function;
    }
}
