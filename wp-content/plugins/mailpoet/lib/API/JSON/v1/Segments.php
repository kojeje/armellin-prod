<?php

namespace MailPoet\API\JSON\v1;

if (!defined('ABSPATH')) exit;


use InvalidArgumentException;
use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\API\JSON\Error as APIError;
use MailPoet\API\JSON\ResponseBuilders\SegmentsResponseBuilder;
use MailPoet\Config\AccessControl;
use MailPoet\Doctrine\Validator\ValidationException;
use MailPoet\Entities\SegmentEntity;
use MailPoet\Listing;
use MailPoet\Models\Segment;
use MailPoet\Segments\SegmentSaveController;
use MailPoet\Segments\SegmentsRepository;
use MailPoet\Segments\WooCommerce;
use MailPoet\Segments\WP;
use MailPoet\WP\Functions as WPFunctions;

class Segments extends APIEndpoint {
  public $permissions = [
    'global' => AccessControl::PERMISSION_MANAGE_SEGMENTS,
  ];

  /** @var Listing\BulkActionController */
  private $bulkAction;

  /** @var Listing\Handler */
  private $listingHandler;

  /** @var SegmentsRepository */
  private $segmentsRepository;

  /** @var SegmentsResponseBuilder */
  private $segmentsResponseBuilder;

  /** @var SegmentSaveController */
  private $segmentSavecontroller;

  /** @var WooCommerce */
  private $wooCommerceSync;

  /** @var WP */
  private $wpSegment;

  public function __construct(
    Listing\BulkActionController $bulkAction,
    Listing\Handler $listingHandler,
    SegmentsRepository $segmentsRepository,
    SegmentsResponseBuilder $segmentsResponseBuilder,
    SegmentSaveController $segmentSavecontroller,
    WooCommerce $wooCommerce,
    WP $wpSegment
  ) {
    $this->bulkAction = $bulkAction;
    $this->listingHandler = $listingHandler;
    $this->wooCommerceSync = $wooCommerce;
    $this->segmentsRepository = $segmentsRepository;
    $this->segmentsResponseBuilder = $segmentsResponseBuilder;
    $this->segmentSavecontroller = $segmentSavecontroller;
    $this->wpSegment = $wpSegment;
  }

  public function get($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $segment = $this->segmentsRepository->findOneById($id);
    if ($segment instanceof SegmentEntity) {
      return $this->successResponse($this->segmentsResponseBuilder->build($segment));
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This list does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function listing($data = []) {
    $listingData = $this->listingHandler->get('\MailPoet\Models\Segment', $data);

    $data = [];
    foreach ($listingData['items'] as $segment) {
      $segment->subscribersUrl = WPFunctions::get()->adminUrl(
        'admin.php?page=mailpoet-subscribers#/filter[segment=' . $segment->id . ']'
      );

      $data[] = $segment
        ->withSubscribersCount()
        ->withAutomatedEmailsSubjects()
        ->asArray();
    }

    return $this->successResponse($data, [
      'count' => $listingData['count'],
      'filters' => $listingData['filters'],
      'groups' => $listingData['groups'],
    ]);
  }

  public function save($data = []) {
    try {
      $segment = $this->segmentSavecontroller->save($data);
    } catch (ValidationException $exception) {
      return $this->badRequest([
        APIError::BAD_REQUEST  => __('Please specify a name.', 'mailpoet'),
      ]);
    } catch (InvalidArgumentException $exception) {
      return $this->badRequest([
        APIError::BAD_REQUEST  => __('Another record already exists. Please specify a different "name".', 'mailpoet'),
      ]);
    }
    $response = $this->segmentsResponseBuilder->build($segment);
    return $this->successResponse($response);
  }

  public function restore($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $segment = Segment::findOne($id);
    if ($segment instanceof Segment) {
      $segment->restore();
      $segment = Segment::findOne($segment->id);
      if(!$segment instanceof Segment) return $this->errorResponse();
      return $this->successResponse(
        $segment->asArray(),
        ['count' => 1]
      );
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This list does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function trash($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $segment = Segment::findOne($id);
    if ($segment instanceof Segment) {
      $segment->trash();
      $segment = Segment::findOne($segment->id);
      if(!$segment instanceof Segment) return $this->errorResponse();
      return $this->successResponse(
        $segment->asArray(),
        ['count' => 1]
      );
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This list does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function delete($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $segment = Segment::findOne($id);
    if ($segment instanceof Segment) {
      $segment->delete();
      return $this->successResponse(null, ['count' => 1]);
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This list does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function duplicate($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $segment = Segment::findOne($id);

    if ($segment instanceof Segment) {
      $data = [
        'name' => sprintf(__('Copy of %s', 'mailpoet'), $segment->name),
      ];
      $duplicate = $segment->duplicate($data);
      $errors = $duplicate->getErrors();

      if (!empty($errors)) {
        return $this->errorResponse($errors);
      } else {
        $duplicate = Segment::findOne($duplicate->id);
        if(!$duplicate instanceof Segment) return $this->errorResponse();
        return $this->successResponse(
          $duplicate->asArray(),
          ['count' => 1]
        );
      }
    } else {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This list does not exist.', 'mailpoet'),
      ]);
    }
  }

  public function synchronize($data) {
    try {
      if ($data['type'] === Segment::TYPE_WC_USERS) {
        $this->wooCommerceSync->synchronizeCustomers();
      } else {
        $this->wpSegment->synchronizeUsers();
      }
    } catch (\Exception $e) {
      return $this->errorResponse([
        $e->getCode() => $e->getMessage(),
      ]);
    }

    return $this->successResponse(null);
  }

  public function bulkAction($data = []) {
    try {
      $meta = $this->bulkAction->apply('\MailPoet\Models\Segment', $data);
      return $this->successResponse(null, $meta);
    } catch (\Exception $e) {
      return $this->errorResponse([
        $e->getCode() => $e->getMessage(),
      ]);
    }
  }
}
