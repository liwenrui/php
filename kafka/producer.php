<?php
$rk = new RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("127.0.0.1:9092");


$topic = $rk->newTopic("test");
for ($i = 0; $i < 100; $i++) {
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, "|||-Message $i");
    $rk->poll(0);
}
