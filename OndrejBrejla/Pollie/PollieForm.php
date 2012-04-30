<?php

namespace OndrejBrejla\Pollie;

use Nette\Application\UI\Form;
use Nette\Application\BadRequestException;

/**
 * PollieForm - part of Pollie plugin for Nette Framework for voting.
 * Uses form with RadioList for realization of the vote.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Pollie
 */
class PollieForm extends Pollie {

    public function createComponentPollieForm() {
        $form = new Form();
        $form->addProtection('Control key is not correct. Do another vote.');

        $answers = array();
        foreach ($this->getAnswers() as $answer) {
            $answers[$answer->id] = $answer->getText();
        }
        $form->addRadioList('pollVoteRadiolist', '', $answers)
                ->addRule(Form::FILLED, 'Select an answer.');

        $form->addSubmit('pollVoteSubmit', 'Vote');

        $form->onSuccess[] = array($this, 'onSuccessVote');

        return $form;
    }

    public function onSuccessVote(Form $form) {
        try {
            $this->model->vote($form->values['pollVoteRadiolist']);
            $this->flashMessage('Your vote has been saved.');
        } catch (BadRequestException $ex) {
            // something to do, when user is not allowed to vote (ex. flash message, ...)
            $this->flashMessage('You have already voted.');
        }

        $this->invalidateControl();
        if (!$this->getPresenter()->isAjax()) {
            $this->redirect('this');
        }
    }

    public function render() {
        $this->template->setFile(dirname(__FILE__) . '/PollieForm.latte');

        $this->template->render();
    }

}
