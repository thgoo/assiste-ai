<?php

namespace App\AssisteAi;

class Flash
{

    /**
     * Create a flash message.
     *
     * @param        $title
     * @param        $message
     * @param        $type
     * @param string $key
     * @return mixed
     */
    protected function create($title, $message, $type, $key = 'flash_message')
    {
        return session()->flash($key, [
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
        ]);
    }

    /**
     * Create an information flash message.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    /**
     * Create a success flash message.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    /**
     * Create a warning flash message.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function warning($title, $message)
    {
        return $this->create($title, $message, 'warning');
    }

    /**
     * Create an error flash message.
     *
     * @param $title
     * @param $message
     * @return mixed
     */
    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    /**
     * Create an overlay flash message.
     *
     * @param        $title
     * @param        $message
     * @param string $type
     * @return mixed
     */
    public function overlay($title, $message, $type = 'info')
    {
        return $this->create($title, $message, $type, 'flash_message_overlay');
    }


}