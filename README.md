[Fifo](https://id.wikipedia.org/wiki/FIFO) queues implement with php [shmop](http://php.net/manual/en/book.shmop.php).

> this library can be used in  `pcntl_fork`,  `worker`  etc.

### usage
``` php
<?php
$q = new Grei\Queue($byte); // default byte
$q->enqueue($item); // add item to queue
$q->dequeue(); // remove one queue
$q->isEmpty(); // cek if queue empty or not
$q->get(); // get one item and trigger dequeue
$q->items(); // list all queue items

```
this library also available as composer packages
```
composer require grei/queue:dev-master
```

