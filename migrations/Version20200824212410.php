<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824212410 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, score INT NOT NULL, comment LONGTEXT DEFAULT NULL, created_date DATETIME NOT NULL, INDEX IDX_794381C63243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $comments = ['Very good location', 'I loved it', 'Good value for money', 
             'Very poor service', 'I do not recommend this place.'];
        $fromDate = new \DateTime('01-01-'.date('Y'));
        $toDate = new \DateTime('01-01-'.(date('Y') - 1));
        for($i = 1; $i <= 10; $i++){
            $this->addSql('INSERT INTO hotel(name) VALUES(\'Hotel'.$i.'\')');
        }

        for($i = 0; $i < 100000; $i++){
            $score = rand(1,5);
            $randomDate = date('Y-m-d H:i', rand($fromDate->getTimestamp(), $toDate->getTimestamp()));
            $comment = $comments[4 - ($score - 1)];
            $hotel = rand(1, 10);
            $this->addSql('INSERT INTO review(hotel_id, score, comment, created_date) VALUES('. $hotel.','.$score.', \''
                                    .$comment.'\', \''.$randomDate.'\')');
            
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C63243BB18');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE review');
    }
}
