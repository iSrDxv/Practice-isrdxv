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
  element\Input,
  element\Dropdown,
  element\Toggle
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
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-title-form"),
      [
        new Label("text", Loader::getinstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-text-form")),
        new Dropdown("language", Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-language-form"), [
          "es_ES",
          "es_MX",
          "en_US"
        ], Loader::getInstance()->getTranslation()->getNumberByLanguage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()))),
        new Toggle("cps", Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-cps-form"), $session->getSetting("cps")),
        new Toggle("score", Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-scoreboard-form"), $session->getSetting("score")),
        new Toggle("queue", Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-queue-form"), $session->getSetting("queue")),
        new Toggle("auto-join", Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($session->getPlayer()->getName()), "settings-join-form"), $session->getSetting("auto-join"))
      ],
      function(Player $player, CustomFormResponse $response): void {
        Loader::getInstance()->getProvider()->setLanguage($player->getName(), Loader::getInstance()->getTranslation()->getLanguageByNumber($response->getInt("language")));
        Loader::getInstance()->getProvider()->saveSettings($player->getName(), [
          "cps" => $response->getBool("cps"), 
          "score" => $response->getBool("score"),
          "queue" => $response->getBool("queue"),
          "auto-join" => $response->getBool("auto-join")
          ]);
        $player->sendMessage("");
      }
    );
  }
  
  public function party(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "party-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "party-text-form"),
      [
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "party-create-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "party-invite-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "party-public-form"))
      ],
      function(Player $player, int $selectedOption): void {
        switch($selectedOption){
          case 0:
          break;
          case 1:
          break;
          case 2:
          break;
        }
      }
    );
  }
  
  public function arena(Player $player): CustomForm
  {
    return new CustomForm("Arena Creator", "create the arenas for practice c:", 
    [
      new Input("arena_name", "Name from Arena", "world"),
      new Dropdown("arena_slots", "Slots for the Arena", [
        "2",
        "4",
        "6"
      ]),
      new Input("arena_mode", "Mode for your Arena", "nodebuff"),
      new Input("arena_type", "Mode for your Arena", "solo"),
      new Toggle("arena_ranked", "Classified Arena or not?", false),
      new Dropdown("arena_type_mode", "Mode Type for Your Server", ["Duel", "FFA"])
    ],
    function(Player $player, CustomFormResponse $response): void {
      $arena_name = $response->getString("arena_name");
      $arena_slots = $response->getInt("arena_slots");
      $arena_mode = $response->getString("arena_mode");
      $arena_type = $response->getString("arena_type");
      $arena_ranked = $response->getBool("arena_ranked");
      $arena_type_mode = $response->getString("arena_type_mode");
      var_dump($arena_name, $arena_slots, $arena_mode, $arena_type, $arena_ranked, $arena_type_mode);
    });
  }
  
  public function ranked(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "ranked-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "ranked-text-form"),
      [
        new MenuOption("Duel \n nodebuff - Players: 0")
      ],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
  public function unranked(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "unranked-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "unranked-text-form"),
      [
        new MenuOption("Duel - nodebuff \n Players: 0")
      ],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
  public function ffa(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "ffa-title-form"),
      Loader::getInstance()->getTranslation()->addMessage(Loader::getInstance()->getProvider()->getLanguage($player->getName()), "ffa-text-form"),
      [
        new MenuOption("NoDebuffMap \n FFA - Players: 0")
      ],
      function(Player $player, int $selectedOption): void {
        //
      }
    );
  }
  
}
