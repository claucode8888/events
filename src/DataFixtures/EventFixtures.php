<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\TicketCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
private array $events = [
    // Music Concerts
    [
        'name' => 'Andrés Calamaro - Tour 2026',
        'description' => 'El Salmón returns with his greatest hits tour across Latin America. Special acoustic set included.',
        'startAt' => '2026-04-15 21:00:00',
        'endAt' => '2026-04-15 23:30:00',
        'capacity' => 8000,
        'status' => 'active',
        'image' => 'calamaro.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 65.00, 'quantity' => 6000],
            ['name' => 'premium', 'price' => 120.00, 'quantity' => 1500],
            ['name' => 'vip-meet-greet', 'price' => 250.00, 'quantity' => 500],
        ]
    ],
    [
        'name' => 'Willie Nelson: Outlaw Festival',
        'description' => 'Country music legend Willie Nelson performs classic hits with special guests.',
        'startAt' => '2026-06-22 19:00:00',
        'endAt' => '2026-06-22 22:00:00',
        'capacity' => 12000,
        'status' => 'active',
        'image' => 'willie-nelson.jpg',
        'tickets' => [
            ['name' => 'lawn', 'price' => 45.00, 'quantity' => 8000],
            ['name' => 'reserved', 'price' => 85.00, 'quantity' => 3000],
            ['name' => 'front-row', 'price' => 150.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Miranda! - Neon Tour',
        'description' => 'Argentine electropop band Miranda! returns with their greatest hits and new album.',
        'startAt' => '2026-05-18 20:30:00',
        'endAt' => '2026-05-18 23:00:00',
        'capacity' => 6000,
        'status' => 'active',
        'image' => 'miranda.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 55.00, 'quantity' => 4500],
            ['name' => 'fan-zone', 'price' => 90.00, 'quantity' => 1200],
            ['name' => 'vip-soundcheck', 'price' => 180.00, 'quantity' => 300],
        ]
    ],
    [
        'name' => 'Mark Knopfler & Dire Straits Legacy',
        'description' => 'An evening with Mark Knopfler performing Dire Straits classics and solo work.',
        'startAt' => '2026-09-05 20:00:00',
        'endAt' => '2026-09-05 22:30:00',
        'capacity' => 10000,
        'status' => 'active',
        'image' => 'knopfler.jpg',
        'tickets' => [
            ['name' => 'standard', 'price' => 75.00, 'quantity' => 7000],
            ['name' => 'gold-circle', 'price' => 135.00, 'quantity' => 2500],
            ['name' => 'platinum', 'price' => 275.00, 'quantity' => 500],
        ]
    ],
    [
        'name' => 'Queen + Adam Lambert Tribute',
        'description' => 'Spectacular tribute show featuring Queen\'s greatest hits with full orchestra.',
        'startAt' => '2026-07-30 19:30:00',
        'endAt' => '2026-07-30 22:00:00',
        'capacity' => 15000,
        'status' => 'active',
        'image' => 'queen-tribute.jpg',
        'tickets' => [
            ['name' => 'upper-tier', 'price' => 60.00, 'quantity' => 10000],
            ['name' => 'lower-tier', 'price' => 95.00, 'quantity' => 4000],
            ['name' => 'royal-box', 'price' => 200.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Symfony World Summit 2026',
        'description' => 'Largest Symfony conference with workshops, keynotes, and community networking.',
        'startAt' => '2026-11-14 09:00:00',
        'endAt' => '2026-11-16 18:00:00',
        'capacity' => 2500,
        'status' => 'active',
        'image' => 'symfony-summit.jpg',
        'tickets' => [
            ['name' => 'early-bird', 'price' => 299.00, 'quantity' => 500],
            ['name' => 'regular', 'price' => 449.00, 'quantity' => 1500],
            ['name' => 'workshop-pass', 'price' => 649.00, 'quantity' => 300],
            ['name' => 'corporate', 'price' => 899.00, 'quantity' => 200],
        ]
    ],
    // Additional events (33 more)
    [
        'name' => 'Coldplay: Music of the Spheres Tour',
        'description' => 'Coldplay returns with their spectacular stadium tour featuring new album.',
        'startAt' => '2026-08-12 20:00:00',
        'endAt' => '2026-08-12 23:00:00',
        'capacity' => 55000,
        'status' => 'active',
        'image' => 'coldplay.jpg',
        'tickets' => [
            ['name' => 'pitch-standing', 'price' => 85.00, 'quantity' => 20000],
            ['name' => 'lower-tier', 'price' => 120.00, 'quantity' => 25000],
            ['name' => 'vip-early-entry', 'price' => 250.00, 'quantity' => 5000],
            ['name' => 'sky-box', 'price' => 500.00, 'quantity' => 5000],
        ]
    ],
    [
        'name' => 'Taylor Swift: The Eras Tour Extension',
        'description' => 'Additional dates for the record-breaking Eras Tour with 3-hour setlist.',
        'startAt' => '2026-09-25 18:30:00',
        'endAt' => '2026-09-25 22:30:00',
        'capacity' => 65000,
        'status' => 'active',
        'image' => 'taylor-swift.jpg',
        'tickets' => [
            ['name' => 'nosebleed', 'price' => 99.00, 'quantity' => 30000],
            ['name' => 'mid-level', 'price' => 199.00, 'quantity' => 25000],
            ['name' => 'floor', 'price' => 349.00, 'quantity' => 8000],
            ['name' => 'vip-package', 'price' => 899.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Ed Sheeran: Mathematics Tour',
        'description' => 'Ed Sheeran performs in-the-round with his signature loop pedal setup.',
        'startAt' => '2026-07-08 19:00:00',
        'endAt' => '2026-07-08 22:00:00',
        'capacity' => 40000,
        'status' => 'active',
        'image' => 'ed-sheeran.jpg',
        'tickets' => [
            ['name' => 'general-admission', 'price' => 75.00, 'quantity' => 30000],
            ['name' => 'reserved-seating', 'price' => 125.00, 'quantity' => 9000],
            ['name' => 'gold-circle', 'price' => 200.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Bad Bunny: Most Wanted Tour',
        'description' => 'Latin trap superstar Bad Bunny brings his high-energy show to stadiums.',
        'startAt' => '2026-10-05 21:00:00',
        'endAt' => '2026-10-05 23:30:00',
        'capacity' => 50000,
        'status' => 'active',
        'image' => 'bad-bunny.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 80.00, 'quantity' => 40000],
            ['name' => 'premium-floor', 'price' => 180.00, 'quantity' => 8000],
            ['name' => 'vip-experience', 'price' => 350.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Beyoncé: Renaissance World Tour',
        'description' => 'Beyoncé\'s critically acclaimed Renaissance album performed live.',
        'startAt' => '2026-08-25 20:00:00',
        'endAt' => '2026-08-25 23:00:00',
        'capacity' => 52000,
        'status' => 'active',
        'image' => 'beyonce.jpg',
        'tickets' => [
            ['name' => 'standard', 'price' => 150.00, 'quantity' => 40000],
            ['name' => 'club-renaissance', 'price' => 400.00, 'quantity' => 10000],
            ['name' => 'golden-experience', 'price' => 800.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Drake & 21 Savage: It\'s All A Blur Tour',
        'description' => 'Drake and 21 Savage co-headline their joint album tour.',
        'startAt' => '2026-09-15 20:30:00',
        'endAt' => '2026-09-15 23:00:00',
        'capacity' => 45000,
        'status' => 'active',
        'image' => 'drake.jpg',
        'tickets' => [
            ['name' => 'upper-level', 'price' => 90.00, 'quantity' => 30000],
            ['name' => 'lower-level', 'price' => 180.00, 'quantity' => 12000],
            ['name' => 'floor', 'price' => 300.00, 'quantity' => 3000],
        ]
    ],
    [
        'name' => 'Harry Styles: Love On Tour Finale',
        'description' => 'Final shows of Harry Styles\' record-breaking Love On Tour.',
        'startAt' => '2026-11-10 19:30:00',
        'endAt' => '2026-11-10 22:00:00',
        'capacity' => 60000,
        'status' => 'active',
        'image' => 'harry-styles.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 85.00, 'quantity' => 45000],
            ['name' => 'pit', 'price' => 200.00, 'quantity' => 10000],
            ['name' => 'vip-soundcheck', 'price' => 450.00, 'quantity' => 5000],
        ]
    ],
    [
        'name' => 'The Weeknd: After Hours Til Dawn Tour',
        'description' => 'The Weeknd performs hits from After Hours and Dawn FM albums.',
        'startAt' => '2026-07-22 20:00:00',
        'endAt' => '2026-07-22 23:00:00',
        'capacity' => 55000,
        'status' => 'active',
        'image' => 'weeknd.jpg',
        'tickets' => [
            ['name' => 'standard', 'price' => 95.00, 'quantity' => 40000],
            ['name' => 'premium', 'price' => 195.00, 'quantity' => 13000],
            ['name' => 'vip-party', 'price' => 395.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Metallica: M72 World Tour',
        'description' => 'Metallica performs two nights with no-repeat setlists.',
        'startAt' => '2026-10-20 19:00:00',
        'endAt' => '2026-10-20 22:30:00',
        'capacity' => 70000,
        'status' => 'active',
        'image' => 'metallica.jpg',
        'tickets' => [
            ['name' => 'general-admission', 'price' => 120.00, 'quantity' => 50000],
            ['name' => 'seated', 'price' => 150.00, 'quantity' => 15000],
            ['name' => 'snakepit', 'price' => 300.00, 'quantity' => 5000],
        ]
    ],
    [
        'name' => 'Red Hot Chili Peppers: Global Stadium Tour',
        'description' => 'RHCP with John Frusciante back on guitar for classic hits.',
        'startAt' => '2026-08-18 19:30:00',
        'endAt' => '2026-08-18 22:00:00',
        'capacity' => 50000,
        'status' => 'active',
        'image' => 'rhcp.jpg',
        'tickets' => [
            ['name' => 'lawn', 'price' => 65.00, 'quantity' => 30000],
            ['name' => 'reserved', 'price' => 120.00, 'quantity' => 18000],
            ['name' => 'gold-circle', 'price' => 250.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Arctic Monkeys: The Car Tour',
        'description' => 'Arctic Monkeys perform songs from The Car and classic albums.',
        'startAt' => '2026-06-28 20:00:00',
        'endAt' => '2026-06-28 22:30:00',
        'capacity' => 35000,
        'status' => 'active',
        'image' => 'arctic-monkeys.jpg',
        'tickets' => [
            ['name' => 'standing', 'price' => 70.00, 'quantity' => 25000],
            ['name' => 'seated', 'price' => 95.00, 'quantity' => 9000],
            ['name' => 'early-entry', 'price' => 150.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Billie Eilish: Hit Me Hard and Soft Tour',
        'description' => 'Billie Eilish performs new album and fan favorites.',
        'startAt' => '2026-09-08 20:00:00',
        'endAt' => '2026-09-08 22:30:00',
        'capacity' => 40000,
        'status' => 'active',
        'image' => 'billie-eilish.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 100.00, 'quantity' => 30000],
            ['name' => 'pit', 'price' => 200.00, 'quantity' => 8000],
            ['name' => 'vip-experience', 'price' => 350.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Bruno Mars: 24K Magic World Tour Return',
        'description' => 'Bruno Mars brings his high-energy show back for encore performances.',
        'startAt' => '2026-10-12 20:00:00',
        'endAt' => '2026-10-12 22:30:00',
        'capacity' => 45000,
        'status' => 'active',
        'image' => 'bruno-mars.jpg',
        'tickets' => [
            ['name' => 'standard', 'price' => 110.00, 'quantity' => 35000],
            ['name' => 'premium', 'price' => 225.00, 'quantity' => 8000],
            ['name' => 'vip-party', 'price' => 450.00, 'quantity' => 2000],
        ]
    ],
    // Technology Conferences
    [
        'name' => 'AWS re:Invent 2026',
        'description' => 'Largest AWS cloud computing conference with technical sessions.',
        'startAt' => '2026-11-28 08:00:00',
        'endAt' => '2026-12-02 18:00:00',
        'capacity' => 50000,
        'status' => 'active',
        'image' => 'aws-reinvent.jpg',
        'tickets' => [
            ['name' => 'virtual', 'price' => 299.00, 'quantity' => 40000],
            ['name' => 'in-person', 'price' => 1799.00, 'quantity' => 9000],
            ['name' => 'enterprise', 'price' => 2999.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Google I/O Extended 2026',
        'description' => 'Google\'s developer conference with Android, AI, and Cloud announcements.',
        'startAt' => '2026-05-10 09:00:00',
        'endAt' => '2026-05-12 18:00:00',
        'capacity' => 15000,
        'status' => 'active',
        'image' => 'google-io.jpg',
        'tickets' => [
            ['name' => 'virtual', 'price' => 0.00, 'quantity' => 100000],
            ['name' => 'in-person', 'price' => 799.00, 'quantity' => 15000],
        ]
    ],
    [
        'name' => 'Apple WWDC 2026',
        'description' => 'Apple Worldwide Developers Conference with iOS, macOS announcements.',
        'startAt' => '2026-06-06 10:00:00',
        'endAt' => '2026-06-10 18:00:00',
        'capacity' => 5000,
        'status' => 'active',
        'image' => 'wwdc.jpg',
        'tickets' => [
            ['name' => 'scholarship', 'price' => 0.00, 'quantity' => 350],
            ['name' => 'standard', 'price' => 1599.00, 'quantity' => 4650],
        ]
    ],
    [
        'name' => 'Microsoft Build 2026',
        'description' => 'Microsoft\'s annual developer conference focusing on Azure and AI.',
        'startAt' => '2026-05-24 09:00:00',
        'endAt' => '2026-05-26 18:00:00',
        'capacity' => 20000,
        'status' => 'active',
        'image' => 'microsoft-build.jpg',
        'tickets' => [
            ['name' => 'virtual', 'price' => 0.00, 'quantity' => 50000],
            ['name' => 'in-person', 'price' => 1299.00, 'quantity' => 20000],
        ]
    ],
    [
        'name' => 'React Conf 2026',
        'description' => 'Official React conference by Meta with latest React features.',
        'startAt' => '2026-10-15 09:00:00',
        'endAt' => '2026-10-16 18:00:00',
        'capacity' => 2000,
        'status' => 'active',
        'image' => 'react-conf.jpg',
        'tickets' => [
            ['name' => 'early-bird', 'price' => 299.00, 'quantity' => 500],
            ['name' => 'regular', 'price' => 499.00, 'quantity' => 1200],
            ['name' => 'corporate', 'price' => 899.00, 'quantity' => 300],
        ]
    ],
    [
        'name' => 'DockerCon 2026',
        'description' => 'Container technology conference with Kubernetes and cloud native focus.',
        'startAt' => '2026-04-18 09:00:00',
        'endAt' => '2026-04-20 18:00:00',
        'capacity' => 8000,
        'status' => 'active',
        'image' => 'dockercon.jpg',
        'tickets' => [
            ['name' => 'virtual', 'price' => 199.00, 'quantity' => 5000],
            ['name' => 'in-person', 'price' => 999.00, 'quantity' => 3000],
        ]
    ],
    [
        'name' => 'Laravel Live 2026',
        'description' => 'Laravel PHP framework conference with workshops and talks.',
        'startAt' => '2026-09-12 09:00:00',
        'endAt' => '2026-09-13 18:00:00',
        'capacity' => 1500,
        'status' => 'active',
        'image' => 'laravel-live.jpg',
        'tickets' => [
            ['name' => 'early-bird', 'price' => 199.00, 'quantity' => 400],
            ['name' => 'regular', 'price' => 299.00, 'quantity' => 800],
            ['name' => 'vip', 'price' => 499.00, 'quantity' => 300],
        ]
    ],
    [
        'name' => 'Vue.js Nation 2026',
        'description' => 'Global Vue.js conference with core team members and community.',
        'startAt' => '2026-01-25 09:00:00',
        'endAt' => '2026-01-26 18:00:00',
        'capacity' => 3000,
        'status' => 'active',
        'image' => 'vue-nation.jpg',
        'tickets' => [
            ['name' => 'virtual', 'price' => 49.00, 'quantity' => 2000],
            ['name' => 'in-person', 'price' => 299.00, 'quantity' => 1000],
        ]
    ],
    // Sports Events
    [
        'name' => 'Super Bowl LXI',
        'description' => 'Super Bowl 61 at SoFi Stadium with halftime show.',
        'startAt' => '2027-02-07 18:30:00',
        'endAt' => '2027-02-07 22:30:00',
        'capacity' => 70000,
        'status' => 'active',
        'image' => 'super-bowl.jpg',
        'tickets' => [
            ['name' => 'upper-level', 'price' => 4500.00, 'quantity' => 40000],
            ['name' => 'lower-level', 'price' => 8500.00, 'quantity' => 25000],
            ['name' => 'club', 'price' => 12500.00, 'quantity' => 5000],
        ]
    ],
    [
        'name' => 'NBA All-Star Game 2026',
        'description' => 'NBA All-Star Weekend including game, dunk contest, and 3-point contest.',
        'startAt' => '2026-02-14 20:00:00',
        'endAt' => '2026-02-16 22:00:00',
        'capacity' => 20000,
        'status' => 'active',
        'image' => 'nba-allstar.jpg',
        'tickets' => [
            ['name' => 'upper-bowl', 'price' => 500.00, 'quantity' => 12000],
            ['name' => 'lower-bowl', 'price' => 1500.00, 'quantity' => 6000],
            ['name' => 'courtside', 'price' => 8000.00, 'quantity' => 2000],
        ]
    ],
    [
        'name' => 'Wimbledon Finals 2026',
        'description' => 'Wimbledon Tennis Championships Men\'s and Women\'s Finals.',
        'startAt' => '2026-07-10 14:00:00',
        'endAt' => '2026-07-12 18:00:00',
        'capacity' => 15000,
        'status' => 'active',
        'image' => 'wimbledon.jpg',
        'tickets' => [
            ['name' => 'grounds-pass', 'price' => 150.00, 'quantity' => 10000],
            ['name' => 'centre-court', 'price' => 350.00, 'quantity' => 4000],
            ['name' => 'royal-box', 'price' => 1200.00, 'quantity' => 1000],
        ]
    ],
    [
        'name' => 'Tour de France Final Stage',
        'description' => 'Final stage of Tour de France on Champs-Élysées in Paris.',
        'startAt' => '2026-07-26 15:00:00',
        'endAt' => '2026-07-26 18:00:00',
        'capacity' => 500000,
        'status' => 'active',
        'image' => 'tour-de-france.jpg',
        'tickets' => [
            ['name' => 'general-viewing', 'price' => 0.00, 'quantity' => 490000],
            ['name' => 'grandstand', 'price' => 200.00, 'quantity' => 10000],
        ]
    ],
    [
        'name' => 'UEFA Champions League Final 2026',
        'description' => 'Champions League Final at Allianz Arena in Munich.',
        'startAt' => '2026-05-30 21:00:00',
        'endAt' => '2026-05-30 23:00:00',
        'capacity' => 75000,
        'status' => 'active',
        'image' => 'ucl-final.jpg',
        'tickets' => [
            ['name' => 'category-3', 'price' => 150.00, 'quantity' => 30000],
            ['name' => 'category-2', 'price' => 300.00, 'quantity' => 25000],
            ['name' => 'category-1', 'price' => 600.00, 'quantity' => 15000],
            ['name' => 'hospitality', 'price' => 1500.00, 'quantity' => 5000],
        ]
    ],
    // Theater & Arts
    [
        'name' => 'Hamilton - Broadway in London',
        'description' => 'Lin-Manuel Miranda\'s award-winning musical at West End.',
        'startAt' => '2026-03-15 19:30:00',
        'endAt' => '2026-03-15 22:30:00',
        'capacity' => 1800,
        'status' => 'active',
        'image' => 'hamilton.jpg',
        'tickets' => [
            ['name' => 'balcony', 'price' => 79.00, 'quantity' => 800],
            ['name' => 'dress-circle', 'price' => 149.00, 'quantity' => 600],
            ['name' => 'stalls', 'price' => 199.00, 'quantity' => 400],
        ]
    ],
    [
        'name' => 'The Lion King - 25th Anniversary',
        'description' => '25th anniversary celebration of Disney\'s The Lion King musical.',
        'startAt' => '2026-06-20 19:00:00',
        'endAt' => '2026-06-20 21:30:00',
        'capacity' => 2000,
        'status' => 'active',
        'image' => 'lion-king.jpg',
        'tickets' => [
            ['name' => 'rear-mezzanine', 'price' => 89.00, 'quantity' => 1000],
            ['name' => 'front-mezzanine', 'price' => 149.00, 'quantity' => 600],
            ['name' => 'orchestra', 'price' => 229.00, 'quantity' => 400],
        ]
    ],
    [
        'name' => 'Les Misérables - Staged Concert',
        'description' => 'Concert version of Les Misérables with full orchestra.',
        'startAt' => '2026-09-30 19:00:00',
        'endAt' => '2026-09-30 22:00:00',
        'capacity' => 5000,
        'status' => 'active',
        'image' => 'les-miserables.jpg',
        'tickets' => [
            ['name' => 'tier-3', 'price' => 65.00, 'quantity' => 3000],
            ['name' => 'tier-2', 'price' => 110.00, 'quantity' => 1500],
            ['name' => 'tier-1', 'price' => 185.00, 'quantity' => 500],
        ]
    ],
    [
        'name' => 'Harry Potter and the Cursed Child',
        'description' => 'Two-part stage play continuing Harry Potter\'s story.',
        'startAt' => '2026-05-05 14:00:00',
        'endAt' => '2026-05-05 22:00:00',
        'capacity' => 1500,
        'status' => 'active',
        'image' => 'harry-potter-play.jpg',
        'tickets' => [
            ['name' => 'matinee', 'price' => 99.00, 'quantity' => 800],
            ['name' => 'evening', 'price' => 129.00, 'quantity' => 500],
            ['name' => 'both-parts', 'price' => 199.00, 'quantity' => 200],
        ]
    ],
    // Festivals
    [
        'name' => 'Coachella Valley Music Festival 2026',
        'description' => 'Weekend 1 of Coachella with art installations and multiple stages.',
        'startAt' => '2026-04-10 12:00:00',
        'endAt' => '2026-04-12 23:59:00',
        'capacity' => 125000,
        'status' => 'active',
        'image' => 'coachella.jpg',
        'tickets' => [
            ['name' => 'general-admission', 'price' => 549.00, 'quantity' => 100000],
            ['name' => 'vip', 'price' => 1099.00, 'quantity' => 20000],
            ['name' => 'safari-tenting', 'price' => 7500.00, 'quantity' => 5000],
        ]
    ],
    [
        'name' => 'Glastonbury Festival 2026',
        'description' => 'World\'s largest greenfield music and performing arts festival.',
        'startAt' => '2026-06-24 09:00:00',
        'endAt' => '2026-06-28 23:59:00',
        'capacity' => 210000,
        'status' => 'active',
        'image' => 'glastonbury.jpg',
        'tickets' => [
            ['name' => 'weekend-ticket', 'price' => 340.00, 'quantity' => 200000],
            ['name' => 'coach-package', 'price' => 420.00, 'quantity' => 10000],
        ]
    ],
    [
        'name' => 'Tomorrowland Belgium 2026',
        'description' => 'Electronic dance music festival in Boom, Belgium.',
        'startAt' => '2026-07-17 12:00:00',
        'endAt' => '2026-07-19 23:59:00',
        'capacity' => 400000,
        'status' => 'active',
        'image' => 'tomorrowland.jpg',
        'tickets' => [
            ['name' => 'full-madness', 'price' => 350.00, 'quantity' => 300000],
            ['name' => 'global-journey', 'price' => 800.00, 'quantity' => 100000],
        ]
    ],
    [
        'name' => 'Burning Man 2026',
        'description' => 'Annual experiment in community and art in Black Rock City.',
        'startAt' => '2026-08-28 00:00:00',
        'endAt' => '2026-09-05 23:59:00',
        'capacity' => 80000,
        'status' => 'active',
        'image' => 'burning-man.jpg',
        'tickets' => [
            ['name' => 'main-sale', 'price' => 575.00, 'quantity' => 60000],
            ['name' => 'fomo-sale', 'price' => 1400.00, 'quantity' => 20000],
        ]
    ],
    // Comedy
    [
        'name' => 'Dave Chappelle: The Final Tour',
        'description' => 'Dave Chappelle\'s alleged final stand-up comedy tour.',
        'startAt' => '2026-11-05 20:00:00',
        'endAt' => '2026-11-05 22:00:00',
        'capacity' => 10000,
        'status' => 'active',
        'image' => 'chappelle.jpg',
        'tickets' => [
            ['name' => 'general', 'price' => 100.00, 'quantity' => 8000],
            ['name' => 'premium', 'price' => 200.00, 'quantity' => 1500],
            ['name' => 'vip-meet', 'price' => 500.00, 'quantity' => 500],
        ]
    ],
    [
        'name' => 'Kevin Hart: Reality Check Tour',
        'description' => 'Kevin Hart\'s new stand-up special recorded live.',
        'startAt' => '2026-10-22 19:30:00',
        'endAt' => '2026-10-22 21:30:00',
        'capacity' => 15000,
        'status' => 'active',
        'image' => 'kevin-hart.jpg',
        'tickets' => [
            ['name' => 'standard', 'price' => 85.00, 'quantity' => 12000],
            ['name' => 'floor', 'price' => 150.00, 'quantity' => 2500],
            ['name' => 'vip', 'price' => 300.00, 'quantity' => 500],
        ]
    ],
];

// Total: 40 events with diverse categories
    public function load(ObjectManager $manager): void
    {
        foreach ($this->events as $eventData) {
            $event = new Event();
            $event->setName($eventData['name']);
            $event->setDescription($eventData['description']);
            $event->setStartAt(new \DateTimeImmutable($eventData['startAt']));
            $event->setEndAt(new \DateTimeImmutable($eventData['endAt']));
            $event->setCapacity($eventData['capacity']);
            $event->setStatus($eventData['status']);
            $event->setImgPath($eventData['image']);
            
            // Add ticket categories
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
    }
    
    /**
     * Creates placeholder images if they don't exist
     * Run this separately or add to load() method
     */
    public function createPlaceholderImages(): void
    {
        $images = ['festival.jpg', 'conference.jpg', 'theater.jpg', 'food-expo.jpg', 'marathon.jpg'];
        $uploadDir = __DIR__ . '/../../public/uploads/events/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        foreach ($images as $image) {
            $path = $uploadDir . $image;
            if (!file_exists($path)) {
                // Create simple placeholder
                $im = imagecreate(800, 400);
                $color = imagecolorallocate($im, rand(50, 200), rand(50, 200), rand(50, 200));
                imagefill($im, 0, 0, $color);
                
                $textColor = imagecolorallocate($im, 255, 255, 255);
                $text = strtoupper(str_replace(['.jpg', '-'], ['', ' '], $image));
                imagestring($im, 5, 300, 180, $text, $textColor);
                
                imagejpeg($im, $path, 80);
                imagedestroy($im);
                
                echo "Created placeholder: $path\n";
            }
        }
    }
}