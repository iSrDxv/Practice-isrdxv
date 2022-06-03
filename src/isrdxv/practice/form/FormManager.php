<?php

namespace isrdxv\practice\form;

use pocketmine\utils\SingletonTrait;
use pocketmine\Server;
use pocketmine\player\Player;

use libs\formapi\{
  BaseForm,
  MenuForm,
  MenuOption,
  CustomForm,
  CustomFormResponse,
  ModalForm,
  element\Label,
  element\Dropdown,
  element\Toggle,
};

use isrdxv\practice\{
  Loader,
  session\Session,
  session\SessionManager,
  queue\QueueManager,
  translation\Translation
};

class FormManager
{
  use SingletonTrait;
  
  public function settings(Session $session): CustomForm
  {
    return new CustomForm(
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-title-form"),
      [
        new Label("text", Loader::getinstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-text-form")),
        new Dropdown("language", Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-language-form"), [
          "es_ES",
          "es_MX",
          "en_US"
        ], Loader::getInstance()->getTranslation()->getNumberByLanguage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()))),
        new Toggle("cps", Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-cps-form"), $session->getSetting("cps")),
        new Toggle("score", Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-scoreboard-form"), $session->getSetting("score")),
        new Toggle("queue", Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-queue-form"), $session->getSetting("queue")),
        new Toggle("auto-join", Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($session->getPlayer()->getName()), "settings-join-form"), $session->getSetting("auto-join"))
      ],
      function(Player $player, CustomFormResponse $response) use ($session): void {
        Loader::getInstance()->getProvider()->setLanguage($player->getName(), Loader::getInstance()->getTranslation()->getLanguageByNumber($response->getInt("language")));
        $session->setSetting("cps", $response->getBool("cps"));
        $session->setSetting("score", $response->getBool("score"));
        $session->setSetting("queue", $response->getBool("queue"));
        $session->setSetting("auto-join", $response->getBool("auto-join"));
      }
    );
  }
  
  public function party(Player $player): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "party-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "party-text-form"),
      [
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "party-create-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "party-invite-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "party-public-form"))
      ],
      function(Player $player, int $selectedOption): void {
        $player->sendMessage("Option number: " . $selectedOption);
      }
    );
  }
  
  public function ranked($player): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "ranked-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "ranked-text-form"),
      [
        new MenuOption("Duel \n nodebuff - Players: 0")
      ],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
  public function unranked($player): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "unranked-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "unranked-text-form"),
      [
        new MenuOption("Duel - nodebuff \n Players: 0")
      ],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
  public function ffa($player): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "ffa-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(SessionManager::getInstance()->getLanguagePlayer($player->getName()), "unranked-text-form"),
      [
        new MenuOption("NoDebuffMap \n FFA - Players: 0")
      ],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
}