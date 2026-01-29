<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\TicketCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
  private array $events = [
    // Music Concerts - TODAY & TOMORROW (For testing categorization)
    [
      'name' => 'Local Jazz Night - Tonight',
      'description' => 'Weekly jazz performances by local artists in an intimate setting.',
      'startAt' => '2026-01-29 20:00:00',
      'endAt' => '2026-01-29 23:00:00',
      'capacity' => 200,
      'status' => 'published',
      'image' => 'jazz-night.jpg',
      'tickets' => [
        ['name' => 'Standard Entry', 'price' => 25.00, 'quantity' => 180],
        ['name' => 'VIP Table', 'price' => 60.00, 'quantity' => 20],
      ]
    ],
    [
      'name' => 'Indie Rock Battle - Tomorrow',
      'description' => 'Local indie rock bands competition with prizes.',
      'startAt' => '2026-01-30 19:30:00',
      'endAt' => '2026-01-30 22:30:00',
      'capacity' => 500,
      'status' => 'published',
      'image' => 'indie-rock.jpg',
      'tickets' => [
        ['name' => 'General Admission', 'price' => 15.00, 'quantity' => 450],
        ['name' => 'Front Row', 'price' => 30.00, 'quantity' => 50],
      ]
    ],
    [
      'name' => 'Techno Warehouse Party - Today',
      'description' => 'Underground techno event with international DJs.',
      'startAt' => '2026-01-29 22:00:00',
      'endAt' => '2026-01-30 06:00:00',
      'capacity' => 800,
      'status' => 'published',
      'image' => 'techno-party.jpg',
      'tickets' => [
        ['name' => 'Early Bird', 'price' => 20.00, 'quantity' => 300],
        ['name' => 'Regular', 'price' => 30.00, 'quantity' => 400],
        ['name' => 'VIP Lounge', 'price' => 50.00, 'quantity' => 100],
      ]
    ],
    
    // THIS WEEKEND
    [
      'name' => 'Andrés Calamaro - Tour 2026',
      'description' => 'El Salmón returns with his greatest hits tour across Latin America.',
      'startAt' => '2026-02-01 21:00:00',
      'endAt' => '2026-02-01 23:30:00',
      'capacity' => 8000,
      'status' => 'published',
      'image' => 'calamaro.jpg',
      'tickets' => [
        ['name' => 'General', 'price' => 65.00, 'quantity' => 6000],
        ['name' => 'Premium', 'price' => 120.00, 'quantity' => 1500],
        ['name' => 'VIP Meet & Greet', 'price' => 250.00, 'quantity' => 500],
      ]
    ],
    [
      'name' => 'Willie Nelson: Outlaw Festival',
      'description' => 'Country music legend performs classic hits with special guests.',
      'startAt' => '2026-02-02 19:00:00',
      'endAt' => '2026-02-02 22:00:00',
      'capacity' => 12000,
      'status' => 'published',
      'image' => 'willie-nelson.jpg',
      'tickets' => [
        ['name' => 'Lawn', 'price' => 45.00, 'quantity' => 8000],
        ['name' => 'Reserved', 'price' => 85.00, 'quantity' => 3000],
        ['name' => 'Front Row', 'price' => 150.00, 'quantity' => 1000],
      ]
    ],
    [
      'name' => 'Miranda! - Neon Tour 2026',
      'description' => 'Argentine electropop band returns with greatest hits and new album.',
      'startAt' => '2026-02-01 20:30:00',
      'endAt' => '2026-02-01 23:00:00',
      'capacity' => 6000,
      'status' => 'published',
      'image' => 'miranda.jpg',
      'tickets' => [
        ['name' => 'General', 'price' => 55.00, 'quantity' => 4500],
        ['name' => 'Fan Zone', 'price' => 90.00, 'quantity' => 1200],
        ['name' => 'VIP Soundcheck', 'price' => 180.00, 'quantity' => 300],
      ]
    ],
    
    // NEXT WEEK
    [
      'name' => 'Mark Knopfler & Dire Straits Legacy',
      'description' => 'An evening with Mark Knopfler performing Dire Straits classics.',
      'startAt' => '2026-02-05 20:00:00',
      'endAt' => '2026-02-05 22:30:00',
      'capacity' => 10000,
      'status' => 'published',
      'image' => 'knopfler.jpg',
      'tickets' => [
        ['name' => 'Standard', 'price' => 75.00, 'quantity' => 7000],
        ['name' => 'Gold Circle', 'price' => 135.00, 'quantity' => 2500],
        ['name' => 'Platinum', 'price' => 275.00, 'quantity' => 500],
      ]
    ],
    [
      'name' => 'Queen + Adam Lambert Tribute',
      'description' => 'Spectacular tribute show featuring Queen\'s greatest hits.',
      'startAt' => '2026-02-07 19:30:00',
      'endAt' => '2026-02-07 22:00:00',
      'capacity' => 15000,
      'status' => 'published',
      'image' => 'queen-tribute.jpg',
      'tickets' => [
        ['name' => 'Upper Tier', 'price' => 60.00, 'quantity' => 10000],
        ['name' => 'Lower Tier', 'price' => 95.00, 'quantity' => 4000],
        ['name' => 'Royal Box', 'price' => 200.00, 'quantity' => 1000],
      ]
    ],
    [
      'name' => 'Local Symphony Orchestra',
      'description' => 'Classical music evening featuring Beethoven and Mozart.',
      'startAt' => '2026-02-08 19:00:00',
      'endAt' => '2026-02-08 21:30:00',
      'capacity' => 1200,
      'status' => 'published',
      'image' => 'symphony.jpg',
      'tickets' => [
        ['name' => 'Balcony', 'price' => 35.00, 'quantity' => 800],
        ['name' => 'Orchestra', 'price' => 65.00, 'quantity' => 300],
        ['name' => 'Box Seats', 'price' => 120.00, 'quantity' => 100],
      ]
    ],
    
    // NEXT MONTH
    [
      'name' => 'Symfony World Summit 2026',
      'description' => 'Largest Symfony conference with workshops and keynotes.',
      'startAt' => '2026-02-28 09:00:00',
      'endAt' => '2026-03-01 18:00:00',
      'capacity' => 2500,
      'status' => 'published',
      'image' => 'symfony-summit.jpg',
      'tickets' => [
        ['name' => 'Early Bird', 'price' => 299.00, 'quantity' => 500],
        ['name' => 'Regular', 'price' => 449.00, 'quantity' => 1500],
        ['name' => 'Workshop Pass', 'price' => 649.00, 'quantity' => 300],
        ['name' => 'Corporate', 'price' => 899.00, 'quantity' => 200],
      ]
    ],
    [
      'name' => 'Coldplay: Music of the Spheres Tour',
      'description' => 'Coldplay returns with their spectacular stadium tour.',
      'startAt' => '2026-03-15 20:00:00',
      'endAt' => '2026-03-15 23:00:00',
      'capacity' => 55000,
      'status' => 'published',
      'image' => 'coldplay.jpg',
      'tickets' => [
        ['name' => 'Pitch Standing', 'price' => 85.00, 'quantity' => 20000],
        ['name' => 'Lower Tier', 'price' => 120.00, 'quantity' => 25000],
        ['name' => 'VIP Early Entry', 'price' => 250.00, 'quantity' => 5000],
        ['name' => 'Sky Box', 'price' => 500.00, 'quantity' => 5000],
      ]
    ],
    [
      'name' => 'Taylor Swift: The Eras Tour Extension',
      'description' => 'Additional dates for the record-breaking Eras Tour.',
      'startAt' => '2026-03-22 18:30:00',
      'endAt' => '2026-03-22 22:30:00',
      'capacity' => 65000,
      'status' => 'published',
      'image' => 'taylor-swift.jpg',
      'tickets' => [
        ['name' => 'Nosebleed', 'price' => 99.00, 'quantity' => 30000],
        ['name' => 'Mid-Level', 'price' => 199.00, 'quantity' => 25000],
        ['name' => 'Floor', 'price' => 349.00, 'quantity' => 8000],
        ['name' => 'VIP Package', 'price' => 899.00, 'quantity' => 2000],
      ]
    ],
    
    // LATER (Beyond next month)
    [
      'name' => 'Ed Sheeran: Mathematics Tour',
      'description' => 'Ed Sheeran performs in-the-round with loop pedal setup.',
      'startAt' => '2026-04-10 19:00:00',
      'endAt' => '2026-04-10 22:00:00',
      'capacity' => 40000,
      'status' => 'published',
      'image' => 'ed-sheeran.jpg',
      'tickets' => [
        ['name' => 'General Admission', 'price' => 75.00, 'quantity' => 30000],
        ['name' => 'Reserved Seating', 'price' => 125.00, 'quantity' => 9000],
        ['name' => 'Gold Circle', 'price' => 200.00, 'quantity' => 1000],
      ]
    ],
    [
      'name' => 'Bad Bunny: Most Wanted Tour 2026',
      'description' => 'Latin trap superstar Bad Bunny brings his high-energy show.',
      'startAt' => '2026-05-05 21:00:00',
      'endAt' => '2026-05-05 23:30:00',
      'capacity' => 50000,
      'status' => 'published',
      'image' => 'bad-bunny.jpg',
      'tickets' => [
        ['name' => 'General', 'price' => 80.00, 'quantity' => 40000],
        ['name' => 'Premium Floor', 'price' => 180.00, 'quantity' => 8000],
        ['name' => 'VIP Experience', 'price' => 350.00, 'quantity' => 2000],
      ]
    ],
    [
      'name' => 'Beyoncé: Renaissance World Tour',
      'description' => 'Beyoncé\'s critically acclaimed Renaissance album performed live.',
      'startAt' => '2026-05-20 20:00:00',
      'endAt' => '2026-05-20 23:00:00',
      'capacity' => 52000,
      'status' => 'published',
      'image' => 'beyonce.jpg',
      'tickets' => [
        ['name' => 'Standard', 'price' => 150.00, 'quantity' => 40000],
        ['name' => 'Club Renaissance', 'price' => 400.00, 'quantity' => 10000],
        ['name' => 'Golden Experience', 'price' => 800.00, 'quantity' => 2000],
      ]
    ],
    [
      'name' => 'Drake & 21 Savage: It\'s All A Blur Tour',
      'description' => 'Drake and 21 Savage co-headline their joint album tour.',
      'startAt' => '2026-06-15 20:30:00',
      'endAt' => '2026-06-15 23:00:00',
      'capacity' => 45000,
      'status' => 'published',
      'image' => 'drake.jpg',
      'tickets' => [
        ['name' => 'Upper Level', 'price' => 90.00, 'quantity' => 30000],
        ['name' => 'Lower Level', 'price' => 180.00, 'quantity' => 12000],
        ['name' => 'Floor', 'price' => 300.00, 'quantity' => 3000],
      ]
    ],
    [
      'name' => 'Harry Styles: Love On Tour Finale',
      'description' => 'Final shows of Harry Styles\' record-breaking Love On Tour.',
      'startAt' => '2026-07-10 19:30:00',
      'endAt' => '2026-07-10 22:00:00',
      'capacity' => 60000,
      'status' => 'published',
      'image' => 'harry-styles.jpg',
      'tickets' => [
        ['name' => 'General', 'price' => 85.00, 'quantity' => 45000],
        ['name' => 'Pit', 'price' => 200.00, 'quantity' => 10000],
        ['name' => 'VIP Soundcheck', 'price' => 450.00, 'quantity' => 5000],
      ]
    ],
    [
      'name' => 'The Weeknd: After Hours Til Dawn Tour',
      'description' => 'The Weeknd performs hits from After Hours and Dawn FM albums.',
      'startAt' => '2026-07-22 20:00:00',
      'endAt' => '2026-07-22 23:00:00',
      'capacity' => 55000,
      'status' => 'published',
      'image' => 'weeknd.jpg',
      'tickets' => [
        ['name' => 'Standard', 'price' => 95.00, 'quantity' => 40000],
        ['name' => 'Premium', 'price' => 195.00, 'quantity' => 13000],
        ['name' => 'VIP Party', 'price' => 395.00, 'quantity' => 2000],
      ]
    ],
    
    // Technology Conferences
    [
      'name' => 'AWS re:Invent 2026',
      'description' => 'Largest AWS cloud computing conference with technical sessions.',
      'startAt' => '2026-11-28 08:00:00',
      'endAt' => '2026-12-02 18:00:00',
      'capacity' => 50000,
      'status' => 'published',
      'image' => 'aws-reinvent.jpg',
      'tickets' => [
        ['name' => 'Virtual', 'price' => 299.00, 'quantity' => 40000],
        ['name' => 'In-Person', 'price' => 1799.00, 'quantity' => 9000],
        ['name' => 'Enterprise', 'price' => 2999.00, 'quantity' => 1000],
      ]
    ],
    [
      'name' => 'Google I/O Extended 2026',
      'description' => 'Google\'s developer conference with Android, AI announcements.',
      'startAt' => '2026-05-10 09:00:00',
      'endAt' => '2026-05-12 18:00:00',
      'capacity' => 15000,
      'status' => 'draft',
      'image' => 'google-io.jpg',
      'tickets' => [
        ['name' => 'Virtual', 'price' => 0.00, 'quantity' => 100000],
        ['name' => 'In-Person', 'price' => 799.00, 'quantity' => 15000],
      ]
    ],
    [
      'name' => 'Apple WWDC 2026',
      'description' => 'Apple Worldwide Developers Conference with iOS announcements.',
      'startAt' => '2026-06-06 10:00:00',
      'endAt' => '2026-06-10 18:00:00',
      'capacity' => 5000,
      'status' => 'pending',
      'image' => 'wwdc.jpg',
      'tickets' => [
        ['name' => 'Scholarship', 'price' => 0.00, 'quantity' => 350],
        ['name' => 'Standard', 'price' => 1599.00, 'quantity' => 4650],
      ]
    ],
    [
      'name' => 'Microsoft Build 2026',
      'description' => 'Microsoft\'s annual developer conference focusing on Azure and AI.',
      'startAt' => '2026-05-24 09:00:00',
      'endAt' => '2026-05-26 18:00:00',
      'capacity' => 20000,
      'status' => 'published',
      'image' => 'microsoft-build.jpg',
      'tickets' => [
        ['name' => 'Virtual', 'price' => 0.00, 'quantity' => 50000],
        ['name' => 'In-Person', 'price' => 1299.00, 'quantity' => 20000],
      ]
    ],
    [
      'name' => 'React Conf 2026',
      'description' => 'Official React conference by Meta with latest React features.',
      'startAt' => '2026-10-15 09:00:00',
      'endAt' => '2026-10-16 18:00:00',
      'capacity' => 2000,
      'status' => 'published',
      'image' => 'react-conf.jpg',
      'tickets' => [
        ['name' => 'Early Bird', 'price' => 299.00, 'quantity' => 500],
        ['name' => 'Regular', 'price' => 499.00, 'quantity' => 1200],
        ['name' => 'Corporate', 'price' => 899.00, 'quantity' => 300],
      ]
    ],
    [
      'name' => 'DockerCon 2026',
      'description' => 'Container technology conference with Kubernetes focus.',
      'startAt' => '2026-04-18 09:00:00',
      'endAt' => '2026-04-20 18:00:00',
      'capacity' => 8000,
      'status' => 'published',
      'image' => 'dockercon.jpg',
      'tickets' => [
        ['name' => 'Virtual', 'price' => 199.00, 'quantity' => 5000],
        ['name' => 'In-Person', 'price' => 999.00, 'quantity' => 3000],
      ]
    ],
    [
      'name' => 'Laravel Live 2026',
      'description' => 'Laravel PHP framework conference with workshops.',
      'startAt' => '2026-09-12 09:00:00',
      'endAt' => '2026-09-13 18:00:00',
      'capacity' => 1500,
      'status' => 'published',
      'image' => 'laravel-live.jpg',
      'tickets' => [
        ['name' => 'Early Bird', 'price' => 199.00, 'quantity' => 400],
        ['name' => 'Regular', 'price' => 299.00, 'quantity' => 800],
        ['name' => 'VIP', 'price' => 499.00, 'quantity' => 300],
      ]
    ],
    [
      'name' => 'Vue.js Nation 2026',
      'description' => 'Global Vue.js conference with core team members.',
      'startAt' => '2026-01-25 09:00:00',
      'endAt' => '2026-01-26 18:00:00',
      'capacity' => 3000,
      'status' => 'cancelled',
      'image' => 'vue-nation.jpg',
      'tickets' => [
        ['name' => 'Virtual', 'price' => 49.00, 'quantity' => 2000],
        ['name' => 'In-Person', 'price' => 299.00, 'quantity' => 1000],
      ]
    ],
    
    // Sports Events
    [
      'name' => 'NBA All-Star Game 2026',
      'description' => 'NBA All-Star Weekend including dunk contest.',
      'startAt' => '2026-02-14 20:00:00',
      'endAt' => '2026-02-16 22:00:00',
      'capacity' => 20000,
      'status' => 'published',
      'image' => 'nba-allstar.jpg',
      'tickets' => [
        ['name' => 'Upper Bowl', 'price' => 500.00, 'quantity' => 12000],
        ['name' => 'Lower Bowl', 'price' => 1500.00, 'quantity' => 6000],
        ['name' => 'Courtside', 'price' => 8000.00, 'quantity' => 2000],
      ]
    ],
    [
      'name' => 'Wimbledon Finals 2026',
      'description' => 'Wimbledon Tennis Championships Men\'s and Women\'s Finals.',
      'startAt' => '2026-07-10 14:00:00',
      'endAt' => '2026-07-12 18:00:00',
      'capacity' => 15000,
      'status' => 'published',
      'image' => 'wimbledon.jpg',
      'tickets' => [
        ['name' => 'Grounds Pass', 'price' => 150.00, 'quantity' => 10000],
        ['name' => 'Centre Court', 'price' => 350.00, 'quantity' => 4000],
        ['name' => 'Royal Box', 'price' => 1200.00, 'quantity' => 1000],
      ]
    ],
    [
      'name' => 'UEFA Champions League Final 2026',
      'description' => 'Champions League Final at Allianz Arena in Munich.',
      'startAt' => '2026-05-30 21:00:00',
      'endAt' => '2026-05-30 23:00:00',
      'capacity' => 75000,
      'status' => 'published',
      'image' => 'ucl-final.jpg',
      'tickets' => [
        ['name' => 'Category 3', 'price' => 150.00, 'quantity' => 30000],
        ['name' => 'Category 2', 'price' => 300.00, 'quantity' => 25000],
        ['name' => 'Category 1', 'price' => 600.00, 'quantity' => 15000],
        ['name' => 'Hospitality', 'price' => 1500.00, 'quantity' => 5000],
      ]
    ],
    
    // Theater & Arts
    [
      'name' => 'Hamilton - Broadway in London',
      'description' => 'Lin-Manuel Miranda\'s award-winning musical at West End.',
      'startAt' => '2026-03-15 19:30:00',
      'endAt' => '2026-03-15 22:30:00',
      'capacity' => 1800,
      'status' => 'published',
      'image' => 'hamilton.jpg',
      'tickets' => [
        ['name' => 'Balcony', 'price' => 79.00, 'quantity' => 800],
        ['name' => 'Dress Circle', 'price' => 149.00, 'quantity' => 600],
        ['name' => 'Stalls', 'price' => 199.00, 'quantity' => 400],
      ]
    ],
    [
      'name' => 'The Lion King - 25th Anniversary',
      'description' => '25th anniversary celebration of Disney\'s The Lion King musical.',
      'startAt' => '2026-06-20 19:00:00',
      'endAt' => '2026-06-20 21:30:00',
      'capacity' => 2000,
      'status' => 'published',
      'image' => 'lion-king.jpg',
      'tickets' => [
        ['name' => 'Rear Mezzanine', 'price' => 89.00, 'quantity' => 1000],
        ['name' => 'Front Mezzanine', 'price' => 149.00, 'quantity' => 600],
        ['name' => 'Orchestra', 'price' => 229.00, 'quantity' => 400],
      ]
    ],
    [
      'name' => 'Les Misérables - Staged Concert',
      'description' => 'Concert version of Les Misérables with full orchestra.',
      'startAt' => '2026-09-30 19:00:00',
      'endAt' => '2026-09-30 22:00:00',
      'capacity' => 5000,
      'status' => 'published',
      'image' => 'les-miserables.jpg',
      'tickets' => [
        ['name' => 'Tier 3', 'price' => 65.00, 'quantity' => 3000],
        ['name' => 'Tier 2', 'price' => 110.00, 'quantity' => 1500],
        ['name' => 'Tier 1', 'price' => 185.00, 'quantity' => 500],
      ]
    ],
    
    // Festivals
    [
      'name' => 'Coachella Valley Music Festival 2026',
      'description' => 'Weekend 1 of Coachella with art installations.',
      'startAt' => '2026-04-10 12:00:00',
      'endAt' => '2026-04-12 23:59:00',
      'capacity' => 125000,
      'status' => 'published',
      'image' => 'coachella.jpg',
      'tickets' => [
        ['name' => 'General Admission', 'price' => 549.00, 'quantity' => 100000],
        ['name' => 'VIP', 'price' => 1099.00, 'quantity' => 20000],
        ['name' => 'Safari Tenting', 'price' => 7500.00, 'quantity' => 5000],
      ]
    ],
    [
      'name' => 'Glastonbury Festival 2026',
      'description' => 'World\'s largest greenfield music festival.',
      'startAt' => '2026-06-24 09:00:00',
      'endAt' => '2026-06-28 23:59:00',
      'capacity' => 210000,
      'status' => 'published',
      'image' => 'glastonbury.jpg',
      'tickets' => [
        ['name' => 'Weekend Ticket', 'price' => 340.00, 'quantity' => 200000],
        ['name' => 'Coach Package', 'price' => 420.00, 'quantity' => 10000],
      ]
    ],
    
    // Comedy
    [
      'name' => 'Dave Chappelle: The Final Tour',
      'description' => 'Dave Chappelle\'s alleged final stand-up comedy tour.',
      'startAt' => '2026-11-05 20:00:00',
      'endAt' => '2026-11-05 22:00:00',
      'capacity' => 10000,
      'status' => 'published',
      'image' => 'chappelle.jpg',
      'tickets' => [
        ['name' => 'General', 'price' => 100.00, 'quantity' => 8000],
        ['name' => 'Premium', 'price' => 200.00, 'quantity' => 1500],
        ['name' => 'VIP Meet', 'price' => 500.00, 'quantity' => 500],
      ]
    ],
    
    // Additional events for better testing
    [
      'name' => 'Food & Wine Festival 2026',
      'description' => 'Annual food festival with local chefs and wineries.',
      'startAt' => '2026-08-15 11:00:00',
      'endAt' => '2026-08-17 22:00:00',
      'capacity' => 5000,
      'status' => 'published',
      'image' => 'food-festival.jpg',
      'tickets' => [
        ['name' => 'Day Pass', 'price' => 45.00, 'quantity' => 4000],
        ['name' => 'Weekend Pass', 'price' => 120.00, 'quantity' => 800],
        ['name' => 'VIP Chef Experience', 'price' => 250.00, 'quantity' => 200],
      ]
    ],
    [
      'name' => 'Marathon City 2026',
      'description' => 'Annual city marathon with 5K, 10K, and full marathon.',
      'startAt' => '2026-10-10 07:00:00',
      'endAt' => '2026-10-10 14:00:00',
      'capacity' => 10000,
      'status' => 'published',
      'image' => 'marathon.jpg',
      'tickets' => [
        ['name' => '5K Run', 'price' => 35.00, 'quantity' => 5000],
        ['name' => '10K Run', 'price' => 50.00, 'quantity' => 3000],
        ['name' => 'Full Marathon', 'price' => 85.00, 'quantity' => 2000],
      ]
    ],
    [
      'name' => 'Art Exhibition Opening',
      'description' => 'Opening night of contemporary art exhibition.',
      'startAt' => '2026-02-20 18:00:00',
      'endAt' => '2026-02-20 22:00:00',
      'capacity' => 300,
      'status' => 'pending',
      'image' => 'art-exhibition.jpg',
      'tickets' => [
        ['name' => 'Standard Entry', 'price' => 20.00, 'quantity' => 250],
        ['name' => 'Premium + Catalog', 'price' => 50.00, 'quantity' => 50],
      ]
    ],
    [
      'name' => 'Startup Pitch Competition',
      'description' => 'Annual startup competition with venture capital prizes.',
      'startAt' => '2026-03-10 09:00:00',
      'endAt' => '2026-03-10 18:00:00',
      'capacity' => 500,
      'status' => 'published',
      'image' => 'startup-pitch.jpg',
      'tickets' => [
        ['name' => 'Audience', 'price' => 25.00, 'quantity' => 400],
        ['name' => 'Investor Pass', 'price' => 150.00, 'quantity' => 100],
      ]
    ],
    [
      'name' => 'Yoga Retreat Weekend',
      'description' => 'Weekend yoga retreat in the mountains.',
      'startAt' => '2026-04-05 16:00:00',
      'endAt' => '2026-04-07 14:00:00',
      'capacity' => 100,
      'status' => 'published',
      'image' => 'yoga-retreat.jpg',
      'tickets' => [
        ['name' => 'Shared Room', 'price' => 350.00, 'quantity' => 80],
        ['name' => 'Private Room', 'price' => 550.00, 'quantity' => 20],
      ]
    ],
  ];

  public function load(ObjectManager $manager): void
  {
    $statuses = ['published', 'draft', 'pending', 'cancelled'];
    
    foreach ($this->events as $eventData) {
      $event = new Event();
      $event->setName($eventData['name']);
      $event->setDescription($eventData['description']);
      $event->setStartAt(new \DateTimeImmutable($eventData['startAt']));
      $event->setEndAt(new \DateTimeImmutable($eventData['endAt']));
      $event->setCapacity($eventData['capacity']);
      $event->setStatus($eventData['status']);
      $event->setImgPath($eventData['image']);
      
      foreach ($eventData['tickets'] as $ticketData) {
        $category = new TicketCategory();
        $category->setName($ticketData['name']);
        $category->setPrice($ticketData['price']);
        $category->setQuantity($ticketData['quantity']);
        $category->setEvent($event);
        
        $event->addTicketCategory($category);
        $manager->persist($category);
      }
      
      $manager->persist($event);
    }
    
    $manager->flush();
    
    echo sprintf("✅ %d events created with images and ticket categories\n", count($this->events));
    echo "Events distributed across time categories:\n";
    echo "- Today/Tomorrow: 3 events\n";
    echo "- This weekend: 3 events\n";
    echo "- Next week: 3 events\n";
    echo "- Next month: 10+ events\n";
    echo "- Later: 20+ events\n";
    echo "Status distribution: published, draft, pending, cancelled\n";
  }
  
  public function createPlaceholderImages(): void
  {
    $images = [];
    foreach ($this->events as $event) {
      $images[] = $event['image'];
    }
    
    $uploadDir = __DIR__ . '/../../public/uploads/events/';
    
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    
    foreach (array_unique($images) as $image) {
      $path = $uploadDir . $image;
      if (!file_exists($path)) {
        $im = imagecreatetruecolor(800, 450);
        $color = imagecolorallocate($im, rand(50, 200), rand(50, 200), rand(50, 200));
        imagefill($im, 0, 0, $color);
        
        $textColor = imagecolorallocate($im, 255, 255, 255);
        $text = strtoupper(str_replace(['.jpg', '.jpeg', '.png', '-'], ['', '', '', ' '], $image));
        imagettftext($im, 24, 0, 100, 225, $textColor, __DIR__ . '/arial.ttf', substr($text, 0, 30));
        
        imagejpeg($im, $path, 85);
        imagedestroy($im);
        
        echo "Created placeholder: $path\n";
      }
    }
  }
}