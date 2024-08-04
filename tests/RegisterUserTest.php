<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {

        /*1. Créer un faux client (navigateur) de pointer vers une URL
        * 2. Remplir les champs de mon formulaire d'inscription
        * 3. Regarder si dans ma page j'ai le message (alert) suivant: Votre compte est créé! Veuillez vous connecter ! 
        */

        //1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

        //2.(email, mdp, confirmation mdp,prénom, nom)
        $client->submitForm('Valider', [
        'register_user[email]' => 'marie@example.fr',
        'register_user[plainPassword][first]'=>'123456789marie',
        'register_user[plainPassword][second]'=>'123456789marie',
        'register_user[firstname]'=>'Marie',
        'register_user[lastname]' =>'Doe'
        ]);
        
        //FOLLOW
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();


        //3.
        $this->assertSelectorExists('div:contains("Votre compte est créé! Veuillez vous connecter !")');


    }
}
