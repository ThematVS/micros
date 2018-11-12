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
    protected $agreements;
    protected $documents;

    protected $id = 12345;
    protected $name = 'Test';
    protected $email = 'themat@i.ua';
    protected $phone = '9999999998';
    protected $address = 'Address';
    protected $connections = [1, 2, 3, 4, 5];
    protected $feeds = ['feed1', 'autofeed'];
    protected $createdAt = '2018-11-09';
    protected $type = '';

    protected function build($data)
    {
        $this->address = new \stdClass();

        $this->address->city = 'SLC';
        $this->address->street = 'street';
        $this->address->house = '11';
        $this->address->apt = '29';

        // create empty entity with autoloaded schema
        //$this->agreement = new Agreement();

        /*
        // create entity with data with autoloaded schema
        $this->agreement = Agreement::fromData([
            'createdAt' => '2018-11-10T00:00:00z',
            'type' => 'Therapy',
            'photo' => 'scan.jpg',
        ]);
        */

        /*
        // create entity with custom schema and initial data
        try {
            $schemaAgreement = new Schema('Agreement');
        } catch (Exception $e) {
            echo 'Cannot create Agreement schema', PHP_EOL;
            exit;
        }

        $this->agreement = new Agreement($schemaAgreement, [
            'createdAt' => '2018-11-10T00:00:00z',
            'type' => 'Therapy',
            'photo' => 'scan.jpg',
        ]);
        */

        //$this->agreements = new AgreementCollection();

        $this->agreements = AgreementCollection::fromData([
            [
                'createdAt' => '2018-11-10T00:00:00z',
                'type' => 'Therapy',
                'photo' => 'scan.jpg',
            ],
            [
                'createdAt' => '2018-10-08T00:00:00z',
                'type' => 'Examination',
                'photo' => 'scan_exam.jpg',
            ]
        ]);
    }

    public function addAgreement($agreement)
    {
        $this->agreements->add($agreement);
    }
}
