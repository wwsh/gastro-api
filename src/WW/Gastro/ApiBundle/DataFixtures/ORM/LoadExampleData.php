<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WW\Gastro\ApiBundle\Entity\Bill;
use WW\Gastro\ApiBundle\Entity\BillOrder;
use WW\Gastro\ApiBundle\Entity\Business;
use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Entity\PaymentType;
use WW\Gastro\ApiBundle\Entity\Place;
use WW\Gastro\ApiBundle\Entity\Product;
use WW\Gastro\ApiBundle\Entity\RoomTable;
use WW\Gastro\ApiBundle\Entity\WorkTime;
use WW\Gastro\ApiBundle\Types\BillStatusType;
use WW\Gastro\ApiBundle\Types\OrderStatusType;
use WW\Gastro\ApiBundle\Types\SexType;
use WW\Gastro\ApiBundle\Types\WorkTimeStatusType;
use WW\Gastro\ApiBundle\ValueObject\Price;


class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $employee = new Employee();
        $employee->setName('Thomas');
        $employee->setSurname('Paderewski');
        $employee->setPincode('1234');
        $employee->setStatus(true);
        $employee->setBirthdate(new \DateTime('1982-01-01'));
        $employee->setSex(SexType::MALE);
        $employee->setStarted(new \DateTime());
        $manager->persist($employee);

        $business = new Business();
        $business->setName('WW');
        $business->setStarted(new \DateTime());
        $business->setStatus(true);
        $business->addEmployee($employee);

        $manager->persist($business);
        $employee->setBusiness($business);
        $manager->persist($employee);
        $manager->flush();

        // setup the restaurant
        $table = new RoomTable();
        $table->setName('Table 1');
        $manager->persist($table);
        $manager->flush();

        $place = new Place();
        $place->setName('01');
        $place->setTable($table);
        $manager->persist($place);
        $manager->flush();

        $place2 = new Place();
        $place2->setName('02');
        $place2->setTable($table);
        $manager->persist($place2);
        $manager->flush();

        $place3 = new Place();
        $place3->setName('03');
        $place3->setTable($table);
        $manager->persist($place3);
        $manager->flush();

        // define payment type
        $pt = new PaymentType();
        $pt->setName('Debit credit card');
        $manager->persist($pt);
        $manager->flush();

        // define 5 example products
        $product0 = new Product();
        $product0->setName('Coca Cola 0.5L');
        $product0->setPrice(new Price(299)); // 2.99
        $manager->persist($product0);
        $manager->flush();
        $product1 = new Product();
        $product1->setName('Aqua 0.3L');
        $product1->setPrice(new Price(99)); // 0.99
        $manager->persist($product1);
        $manager->flush();
        $product2 = new Product();
        $product2->setName('Beef stake');
        $product2->setPrice(new Price(1399)); // 13.99
        $manager->persist($product2);
        $manager->flush();
        $product3 = new Product();
        $product3->setName('Chicken Torilla');
        $product3->setPrice(new Price(999)); // 9.99
        $manager->persist($product3);
        $manager->flush();
        $product4 = new Product();
        $product4->setName('Local Tea');
        $product4->setPrice(new Price(599)); // 5.99
        $manager->persist($product4);
        $manager->flush();

        // lets go to work
        $worktime = new WorkTime();
        $worktime->setStart(new \DateTime());
        $worktime->setStatus(WorkTimeStatusType::WORKING);
        $worktime->setEmployee($employee);
        $manager->persist($worktime);
        $manager->flush();

        // and make some order
        $order = new BillOrder();
        $order->addProduct($product3);
        $order->addProduct($product0);
        $order->setStatus(OrderStatusType::REQUESTED);
        $manager->persist($order);
        $manager->flush();

        // create bill
        $bill = new Bill();
        $bill->addOrder($order);
        $bill->setPaymentType($pt);
        $bill->setStart(new \DateTime());
        $bill->setPrice(new Price(1298));
        $bill->setEmployee($employee);
        $bill->setPlace($place);
        $bill->setWorktime($worktime);
        $bill->setStatus(BillStatusType::OPEN);
        $manager->persist($bill);
        $manager->flush();

        // link order to bill
        $order->setBill($bill);
        $manager->persist($order);
        $manager->flush();

        // add another order
        $order = new BillOrder();
        $order->addProduct($product1);
        $order->addProduct($product2);
        $order->setStatus(OrderStatusType::REQUESTED);
        $manager->persist($order);
        $manager->flush();

        // create new bill
        $bill = new Bill();
        $bill->addOrder($order);
        $bill->setPaymentType($pt);
        $bill->setStart(new \DateTime());
        $bill->setPrice(new Price(1598));
        $bill->setEmployee($employee);
        $bill->setPlace($place2);
        $bill->setWorktime($worktime);
        $bill->setStatus(BillStatusType::OPEN);
        $manager->persist($bill);
        $manager->flush();

        // link order to bill
        $order->setBill($bill);
        $manager->persist($order);
        $manager->flush();

        // .. and last order and bill, successfully completed
        $order = new BillOrder();
        $order->addProduct($product3);
        $order->addProduct($product4);
        $order->setStatus(OrderStatusType::COMPLETE);
        $manager->persist($order);
        $manager->flush();

        // create new bill
        $bill = new Bill();
        $bill->addOrder($order);
        $bill->setPaymentType($pt);
        $bill->setStart(new \DateTime());
        $bill->setEnd(new \DateTime());
        $bill->setPrice(new Price(1598));
        $bill->setEmployee($employee);
        $bill->setPlace($place3);
        $bill->setWorktime($worktime);
        $bill->setStatus(BillStatusType::PAID);
        $manager->persist($bill);
        $manager->flush();

        // link order to bill
        $order->setBill($bill);
        $manager->persist($order);
        $manager->flush();
    }
}