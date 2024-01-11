<?php

namespace isrdxv\practice\form;

use isrdxv\practice\{
  Loader,
  session\Session,
  session\SessionManager,
  translation\Translation
};

class PartyMenuForm extends MenuForm
{
  
  public function __construct(Session $session)
  {
    parent::__construct(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-title-form"),
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-text-form"),
      [
        new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-create-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-invite-form")),
         new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-public-form"))
      ],
      function(Player $player, int $selectedOption): void {
        switch($selectedOption){
          case 0:
            $player->sendMessage("coming soon...");
          break;
          case 1:
            $player->sendMessage("coming soon...");
          break;
          case 2:
            $player->sendMessage("coming soon...");
          break;
        }
      }
    );
  }
}