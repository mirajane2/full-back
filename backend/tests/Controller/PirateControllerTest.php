<?php 

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PirateControllerTest extends WebTestCase {

    private $client;

    private $token;

    protected function setUp(): void {
        $this -> client = static::createClient();

        $this -> client -> request('POST', '/api/login', [], [], 
        ['CONTENT_TYPE' => 'application/json'],
            json_encode( [
            'username' => 'user@equipage.com',
            'password' => 'password'
        ]) );

        $response = json_decode($this -> client -> getResponse() -> getContent(), true);


        $this -> token = $response['token'] ?? null;

        if(!$this-> token) {
            $this-> fail('Impossible de recuperer le token');
        }
    }
    public function testReadAfficheSucess() {

          
        $this -> client -> request('GET', '/api/pirate', [], [], 
        ['CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            json_encode( [
            'username' => 'user@equipage.com',
            'password' => 'password'
        ]) );      
        $this -> assertResponseIsSuccessful();        
        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertNotEmpty($responseData, 'La liste des affiche est vide');

    }

    public function testCreateAfficheSuccess() {


        $data = [
            'name' => 'Luffy',
            'description' => 'DEAD or LIFE',
            'img' => 'hvbccceds',
            'prime' => '3 000 000 000',
            'equipage' => 'Equipage du chapeau de paille'
        ];

        $this->client->request('POST', '/api/pirate/create', [], [], 
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
            ],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Affiche created successfully', $responseData['message']);
    }
    

    public function testUpdateAfficheSucess() {

        $existingId = 14;
        $data = [
            'name' => 'Luffy',
            'description' => 'DEAD or LIFE',
            'img' => 'homme élastique',
            'prime' => '550 000 000',
            'equipage' => 'Equipage du chapeau de paille'
        ];

        $this -> client -> request('PUT', '/api/pirate/update/' . $existingId,[], [], 
        [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
            ],
        json_encode($data)
        );
        $this -> assertResponseIsSuccessful();  
        $responseData = json_decode($this->client->getResponse()->getContent(), true);  
        $this->assertEquals('Affiche modifié avec succès', $responseData['message']);
    }

    public function testDeleteAfficheSuccess() {
            $existingId = 14;

 
            $this->client->request('DELETE', '/api/pirate/delete/' . $existingId, [], [], [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
            ]);


            $this->assertResponseIsSuccessful();

            $responseData = json_decode($this->client->getResponse()->getContent(), true);
            $this->assertEquals('Affiche supprimé avec succès', $responseData['message']);
    }    
}