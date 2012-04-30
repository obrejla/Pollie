<?php

namespace OndrejBrejla\Pollie;

use Nette\Application\BadRequestException;

/**
 * PollieLink - part of Pollie plugin for Nette Framework for voting.
 * Uses links for realization of the vote.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Pollie
 */
class PollieLink extends Pollie {

    public function handleVote($id) {
        try {
            $this->model->vote($id);
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
        $this->template->setFile(dirname(__FILE__) . '/PollieLink.latte');

        $this->template->render();
    }

}
