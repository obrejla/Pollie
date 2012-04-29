<?php

/**
 * FormPollControl - part of PollControl plugin for Nette Framework for voting.
 * Uses links for realization of the vote.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Nette-PollControl
 */
class LinkPollControl extends PollControl {

    public function handleVote($id) {
        try {
            $this->model->vote($id);
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
        $this->template->setFile(dirname(__FILE__) . '/LinkPollControl.latte');

        $this->template->render();
    }

}
