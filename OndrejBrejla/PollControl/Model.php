<?php

namespace OndrejBrejla\PollControl;

/**
 * Model - part of PollControl plugin for Nette Framework for voting.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Nette-PollControl
 */
interface Model {

    /**
     * Returns count of all votes of the poll.
     *
     * @return int Count of all votes of the poll.
     */
    public function getAllVotesCount();

    /**
     * Returns question of the poll.
     *
     * @return string Question of the poll.
     */
    public function getQuestion();

    /**
     * Returns array of answers.
     *
     * @return Answer[] Array of answers.
     */
    public function getAnswers();

    /**
     * Checks if current poll is votable for user, or not. If he had already vote, or not.
     *
     * @return boolean TRUE, if user can vote.
     */
    public function isVotable();

}

