<?php
namespace Micros\Entity;

use Micros\Foundation\AggregateEntity;

require_once '../vendor/autoload.php';

class Patient extends AggregateEntity
{
    private $treatmentType;
    private $referenceType;
    private $personal;
    private $contact;
    private $passport;
    private $payment;
    private $healthState;
    private $cardId;
    private $parents;
    private $discount;
    private $registerDate;
    private $insurance;
    private $photos;
    private $agreement;
    private $documents;

    protected function build()
    {
    }
}
