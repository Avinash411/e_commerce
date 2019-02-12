<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as IlluminateResponse;
class ApiController extends Controller
{
    protected  $statusCode=200 ; 
    public function getStatusCode(){
       return $this->statusCode;
    }
    public function setStatusCode($statusCode){
        $this->statusCode=$statusCode;
        return $this;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //if product not available
    public function respondNotFound($message ='Not Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
        
    }

 public function respondForBadRequest($message ='Bad Request!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->respondWithError($message);
        
    }
    public function respondForUnauthorized($message ='UNAUTHORIZED Request!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
        
    }
    
    public function respondForCreated($message ='Request Created!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respondWithError($message);
        
    }
    public function respondForOk($message ='Request Ok!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respondWithError($message);
        
    }
    public function respondForAccepted($message ='Request ACCEPTED!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_ACCEPTED)->respondWithError($message);
        
    }
    public function respondForNotAcceptable($message ='Request NOT ACCEPTABLE!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_ACCEPTABLE)->respondWithError($message);
        
    }
    public function respondForLargeEntity($message ='Request Entity Too Large!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_REQUEST_ENTITY_TOO_LARGE)->respondWithError($message);
        
    }
    public function respondForTimeout($message ='Request Timeout!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_REQUEST_TIMEOUT)->respondWithError($message);
        
    }
    public function respondForTooMany($message ='Too Many Requests!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_TOO_MANY_REQUESTS)->respondWithError($message);
        
    }
    public function respondForNotAvailable($message ='Request Not Available!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_SERVICE_UNAVAILABLE)->respondWithError($message);
        
    }
     public function respondForNotAvailableOfLegalReason($message ='Request Not Available For Legal Reasons!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS)->respondWithError($message);
        
    }
    public function respondForNotImplemented($message ='Request Not Implemented!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_IMPLEMENTED)->respondWithError($message);
        
    }
    public function respondForNotPreconditionRequired($message ='PRECONDITION REQUIRED!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_PRECONDITION_REQUIRED)->respondWithError($message);
        
    }
    public function respondForNoContent($message ='No Content Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NO_CONTENT)->respondWithError($message);
        
    }
     public function respondForPayment($message ='Payment REQUIRED!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_PAYMENT_REQUIRED)->respondWithError($message);
        
    }
    public function respondForNotTooEarly($message ='Request Too Early!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_TOO_EARLY)->respondWithError($message);
        
    }
    public function respondForLockedRequest($message ='Request Locked!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_LOCKED)->respondWithError($message);
        
    }
    public function respondForUnprocessableRequest($message ='Unprocessable Entity Request!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
        
    }
    public function respondForNotFailedDependency($message ='Request Dependency Failed!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FAILED_DEPENDENCY)->respondWithError($message);
        
    }

    public function respondForTooLargeHeader($message ='Request Header field Too large!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE)->respondWithError($message);
        
    }
     public function respondForNotRequiredNetwork($message ='NETWORK AUTHENTICATION REQUIRED!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NETWORK_AUTHENTICATION_REQUIRED)->respondWithError($message);
        
    }
    public function respondForVersionNotSupport($message ='Request Vesion Not Supported!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_VERSION_NOT_SUPPORTED)->respondWithError($message);
        
    }
    
     //internal error
    public function respondInternalError($message ='Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
        
    }


    public function respond($data,$headers=[] ){
          
          return Response::json($data,$this->getStatusCode(),$headers);
    }


       public function respondWithError($message){
        return $this->respond([
           'Response'=>[
              'message'=>$message,
              'code'=>$this->getStatusCode()

           ]
        ]);
   }
    
}
