<?php
/**
 * PHP in memory FIFO queue
 *
 * PHP version 5, 7
 *
 * @category  library
 * @package   queue
 * @author    guangrei <grei@tuta.io>
 * @license   MIT http://opensource.org/licenses/MIT
 * @link      https://github.com/guangrei/queue
 */

namespace Grei;
use Exception;
class Queue
{
    public $shm_id;
    public $shm_size;
    public $items;
    
    public function __construct($byte = 1000000)
    {
        $this->shm_id = shmop_open(0xff3, "c", 0644, $byte);
        if (!$this->shm_id) {
            throw new Exception("Couldn't create shared memory segment");
        } else {
            $this->items = shmop_write($this->shm_id, serialize([]), 0);
            $this->shm_size = shmop_size($this->shm_id);
        }
            
    }
    
    public function isEmpty()
    {
        $items = unserialize(shmop_read($this->shm_id, 0, $this->shm_size));
        return empty($items);
    }
    
    public function enqueue($item)
    {
        $array = unserialize(shmop_read($this->shm_id, 0, $this->shm_size));
        array_unshift($array, $item);
        $this->items = shmop_write($this->shm_id, serialize($array), 0);
        $this->shm_size = shmop_size($this->shm_id);
    }
    
    public function dequeue()
    {
        $array = unserialize(shmop_read($this->shm_id, 0, $this->shm_size));
        array_pop($array);
        $this->items = shmop_write($this->shm_id, serialize($array), 0);
        $this->shm_size = shmop_size($this->shm_id);
    }
    
    public function items()
    {
        return unserialize(shmop_read($this->shm_id, 0, $this->shm_size));
    }
    
    public function get()
    {
        $array = unserialize(shmop_read($this->shm_id, 0, $this->shm_size));
        $this->dequeue();
        return end($array);
    }
    
    public function close()
    {
        if (!shmop_delete($this->shm_id)) {
            throw new Exception("Couldn't mark shared memory block for deletion.");
        }
        shmop_close($this->shm_id);
    }
}
