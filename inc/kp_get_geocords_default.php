<?php

function kp_get_geocords_default($locale, $cordType) {
  switch($locale) {
    case 'pl_PL':
      if($cordType === 'lat') return '52.237049';
      else if ($cordType === 'lng') return '19.017532';
      break;
    case 'en_US':
      if($cordType === 'lat') return '47.944921';
      else if ($cordType === 'lng') return '6.215274';
      break;
    case 'sk_SK':
      if($cordType === 'lat') return '48.621792';
      else if ($cordType === 'lng') return '18.54746';
      break;
    case 'de_DE':
      if($cordType === 'lat') return '47.4886209';
      else if ($cordType === 'lng') return '12';
      break;
    case 'sv_SE':
      if($cordType === 'lat') return '52.237049';
      else if ($cordType === 'lng') return '19.017532';
      break;
    case 'cs_CZ':
      if($cordType === 'lat') return '49.518701';
      else if ($cordType === 'lng') return '14.777863';
      break;
    case 'fr_FR':
      if($cordType === 'lat') return '46.404751';
      else if ($cordType === 'lng') return '1.2544063';
      break;
	case 'ro_RO':
      if($cordType === 'lat') return '45.943161';
      else if ($cordType === 'lng') return '24.966761';
      break;
    default:
      if($cordType === 'lat') return '52.237049';
      else if ($cordType === 'lng') return '19.017532';
      break;
  }
}