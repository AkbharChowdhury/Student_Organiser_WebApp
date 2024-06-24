<?php

enum Status: string
{
  case  COMPLETE = 'success';
  case IN_PROGRESS = 'warning';
  case IN_COMPLETE  = 'danger';
}
