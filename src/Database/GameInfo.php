<?php

namespace Chess\Database;
class GameInfo
{
    private string $moveText;

    /**
     * Get the value of moveText
     */ 
    public function getMoveText()
    {
        return $this->moveText;
    }

    /**
     * Set the value of moveText
     *
     * @return  self
     */ 
    public function setMoveText(string $moveText)
    {
        $this->moveText = $moveText;

        return $this;
    }
}