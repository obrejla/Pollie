<?php

/**
 * FormPollControl - part of PollControl plugin for Nette Framework for voting.
 * Uses links for realization of the vote.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://nettephp.com/cs/extras/poll-control
 * @package    Nette\Extras
 * @version    0.1.1
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
        $this->template->setFile(dirname(__FILE__) . '/LinkPollControl.phtml');

        $this->template->render();
    }

}
