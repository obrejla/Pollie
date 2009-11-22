<?php

/**
 * FormPollControl - part of PollControl plugin for Nette Framework for voting.
 * Uses form with RadioList for realization of the vote.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Nette-PollControl
 * @package    Nette\Extras
 * @version    0.1
 */
class FormPollControl extends PollControl {

    public function createComponentPollControlForm() {
        $form = new AppForm();
        $form->addProtection('Kontrolní klíč nesouhlasí. Opakujte hlasování.');

        $answers = array();
        foreach ($this->getAnswers() as $answer) {
            $answers[$answer->id] = $answer->getText();
        }
        $form->addRadioList('pollVoteRadiolist', '', $answers)
                ->addRule(Form::FILLED, 'Před odesláním vyberte odpověď.');

        $form->addSubmit('pollVoteSubmit', 'Hlasovat');

        $form->onSubmit[] = array($this, 'onSubmitVote');

        return $form;
    }

    public function onSubmitVote(AppForm $form) {
        try {
            $this->model->vote($form->values['pollVoteRadiolist']);
            $this->flashMessage('Váš hlas byl uložen.');
        } catch (BadRequestException $ex) {
            // something to do, when user is not allowed to vote (ex. flash message, ...)
            $this->flashMessage('Již jste hlasoval(a).');
        }

        $this->invalidateControl();
        if (!$this->getPresenter()->isAjax()) {
            $this->redirect('this');
        }
    }

    public function render() {
        $this->template->setFile(dirname(__FILE__) . '/FormPollControl.phtml');

        $this->template->render();
    }

}
