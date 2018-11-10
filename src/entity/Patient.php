<?php
namespace Micros\Entity;

use Micros\Foundation\AggregateEntity;
use Micros\Foundation\Schema;

/**
 * Patient entity
 */
class Patient extends AggregateEntity
{
    protected $treatmentType;
    protected $referenceType;
    protected $personal;
    protected $contact;
    protected $passport;
    protected $payment;
    protected $healthState;
    protected $cardId;
    protected $parents;
    protected $discount;
    protected $registerDate;
    protected $insurance;
    protected $photos;
    protected $agreement;
    protected $documents;

    protected $id = 12345;
    protected $name = 'Test';
    protected $email = 'themat@i.ua';
    protected $phone = '9999999998';
    protected $address = 'Address';
    protected $connections = [1, 2, 3, 4, 5];
    protected $feeds = ['feed1', 'autofeed'];
    protected $createdAt = '2018-11-10';

    protected function build($data)
    {
        $this->address = new \stdClass();

        $this->address->city = 'SLC';
        $this->address->street = 'street';
        $this->address->house = '11';
        $this->address->apt = '29';

        try {
            $schemaAgreement = new Schema('Agreement');
        } catch (Exception $e) {
            echo 'Cannot create Agreement schema', PHP_EOL;
            exit;
        }
        
        $this->agreement = new Agreement($schemaAgreement, [
            'createAt' => '2018-11-10',
            'type' => 'Therapy',
            'photo' => 'scan.jpg',
        ]);
    }
}
