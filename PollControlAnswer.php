<?php

use Nette\Object;

/**
 * PollControlAnswer - part of PollControl plugin for Nette Framework for voting.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Nette-PollControl
 */
class PollControlAnswer extends Object {

    /**
     * Id of the answer.
     *
     * @var mixed Id of the answer.
     */
    private $id;

    /**
     * Text of the answer.
     *
     * @var string Text of the answer.
     */
    private $text;

    /**
     * Votes count of the answer.
     *
     * @var int Votes count of the answer.
     */
    private $votesCount;

    /**
     * Constructor of the answer.
     *
     * @param string $text Text of the answer.
     * @param mixed $id Id of the answer.
     * @param int $votesCount Votes count of the answer.
     */
    public function __construct($text, $id, $votesCount) {
        $this->text = $text;
        $this->id = $id;
        $this->votesCount = $votesCount;
    }

    /**
     * Returns text of the answer.
     *
     * @return string Text of the answer.
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Returns id of the answer.
     *
     * @return mixed Id of the answer.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns votes count of the answer.
     *
     * @return int Votes count of the answer.
     */
    public function getVotesCount() {
        return $this->votesCount;
    }

}
