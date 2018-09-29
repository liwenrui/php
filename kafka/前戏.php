1.启动zookeeper
    bin/zookeeper-server-start.sh config/zookeeper.properties

2.启动kafka
    bin/kafka-server-start.sh config/server.properties

3.创建topic
    bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 2 --topic test

    注意 这里的--partitions 2 决定一个group内最多能有几个consumer并发消费

4.执行consumer1.consumer2准备接受数据

5.执行producer写数据

6.观察情况

7.再执行consumer3,观察情况

8.等几秒钟后再次观察情况
(consumer的切换)