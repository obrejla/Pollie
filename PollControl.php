<?php

use Nette\Environment;
use Nette\Application\UI\Control;

/**
 * PollControl - plugin for Nette Framework for voting.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Nette-PollControl
 */
abstract class PollControl extends Control {

    /**
     * Identification string of csrf token for GET and POST methods and session namespace.
     *
     * @var string Identification string of csrf token.
     */
    const CSRF_IDENTIFIER = '__csrf_link_token';

    /**
     * Model layer object.
     *
     * @var PollControlModel Model layer object.
     */
    private $model = NULL;

    /**
     * Factory method for creating requested poll type (Link, Form, ...).
     *
     * @param string $poll Name of requested poll type.
     * @return PollControl Object of requested poll type.
     */
    public static function factory($poll) {
        switch ($poll) {
            case 'link': return new LinkPollControl();
                    break;
            case 'form': return new FormPollControl();
                    break;

            default: throw new InvalidArgumentException('Bad factory argument - ' . $poll);
        }
    }

    /**
     * Sets new model layer of the poll.
     *
     * @param PollControlModel $model Model layer for the poll.
     * @return void
     */
    public function setModel(PollControlModel $model) {
        $this->model = $model;
    }

    /**
     * Returns model layer of the poll.
     *
     * @return IPollControlModel Model layer for the poll.
     */
    public function getModel() {
        if ($this->model === NULL) {
            throw new InvalidStateException('Can not use PollControl without model layer implementing IPollControlModel interface.');
        }

        return $this->model;
    }

    /**
     * Returns array of answers of the poll (user for check answer type).
     *
     * @return PollControlAnswer Array of answers for the poll.
     */
    public function getAnswers() {
        $answers = $this->model->getAnswers();

        foreach ($answers as $answer) {
            if (!($answer instanceof PollControlAnswer)) {
                throw new InvalidStateException('Answers have to be PollControlAnswer objects.');
            }
        }

        return $answers;
    }

    /**
     * @see PresenterComponent::link($destination, $args = array())
     */
    public function link($destination, $args = array()) {
        $args[self::CSRF_IDENTIFIER] = $this->generateCsrfLinkToken();

        return parent::link($destination, $args);
    }

    /**
     * @see PresenterComponent::signalReceived($signal)
     */
    public function signalReceived($signal) {
        if (!$this->checkCsrfLinkToken()) {
            $sess = Environment::getSession(self::CSRF_IDENTIFIER);
            unset($sess->csrfLinkToken);

            throw new BadSignalException('CSRF token expired, try again.');
        }

        parent::signalReceived($signal);
    }

    /**
     * Creates new template and sets variables.
     *
	 * @param mixed $class
     * @return ITemplate Template.
     */
    protected function createTemplate($class = NULL) {
        $template = parent::createTemplate();

        $template->question = $this->model->getQuestion();
        $template->answers = $this->getAnswers();
        $template->allVotesCount = $this->model->getAllVotesCount();
        $template->isVotable = $this->model->isVotable();

        return $template;
    }

    /**
     * Returns CSRF hash token.
     *
     * @return string CSRF hash token.
     */
    private function generateCsrfLinkToken() {
        $sess = Environment::getSession(self::CSRF_IDENTIFIER);

        if ($sess->csrfLinkToken === NULL) {
            $sess->csrfLinkToken = md5(rand(1, 1e9));
        }

        return $sess->csrfLinkToken;
    }

    /**
     * Checks CSRF token passed by link.
     *
     * @return boolean TRUE if passed CSRF token equals with token in session.
     */
    private function checkCsrfLinkToken() {
        $sess = Environment::getSession(self::CSRF_IDENTIFIER);

        if ($sess->csrfLinkToken !== $this->getParam(self::CSRF_IDENTIFIER)) {
            return FALSE;
        }

        return TRUE;
    }

}
