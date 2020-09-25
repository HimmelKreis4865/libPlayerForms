# libPlayerForms
[![Discord](https://img.shields.io/discord/692324167281934386?color=informational&label=discord)](https://discord.gg/2pADFQW)

A simple and lightweight API for creating and sending forms to players

# Fetures
- Dynamic Form creation
- Fast-loading images
- Client-Settings Form

# Examples
First, you have to register your Plugin for PlayerForms, otherwise you can't use all features.
```php
if(!\libPlayerForms\handler\HandlerManager::isRegistered())
    \libPlayerForms\handler\HandlerManager::register($this);
```

Now you can create a Form like this
```php
(new \libPlayerForms\form\SimpleForm("Title", "Description"))
    ->addElement(new Button("§cApple", new ButtonImage("https://www.neurodermitis-bund.de/assets/images/a/apfel_juni_2019-40b09b3f.jpg", ButtonImage::TYPE_URL)))
    ->addElement(new Button("§gBanana", new ButtonImage("https://www.kochschule.de/sites/default/files/images/kochwissen/440/banane.jpg", ButtonImage::TYPE_URL)))
   	->addElement(new Button("§6Orange", new ButtonImage("https://i0.wp.com/www.agriculturenigeria.com/wp-content/uploads/2020/01/orange-1.jpg", ButtonImage::TYPE_URL)))
   	->setCloseListener(function(Player $player) : void{
   		$player->sendMessage("You just close the form");
  	})
    ->setSubmitListener(function(Player $player, FormResponse $response) : void{
    	$player->sendMessage("You like {$response->getElementById($response->getActualResponse())->getText()}!");
    })
    ->send($player);
```