<?php

  class Person {

    public function who_am_i() {
      return "I am {$this->FirstName} {$this->LastName}
              and  my nickname is {$this->NickName}";
    }
  }

?>
