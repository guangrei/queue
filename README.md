[Fifo](https://id.wikipedia.org/wiki/FIFO) queues implement with php [shmop](http://php.net/manual/en/book.shmop.php).

> this library can be used in  `pcntl_fork`,  `worker`  etc.

### usage
``` php
<?php
$q = new Grei\Queue($byte); // default 1000000 byte
$q->enqueue($item); // add item to queue
$q->dequeue(); // remove one item
$q->isEmpty(); // check if queue empty or not
$q->get(); // get one item and trigger dequeue
$q->items(); // list all queue items
$q->close(); // close queue/shmop memory

```
this library also available as composer packages
```
composer require grei/queue
```

