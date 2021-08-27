<?php
declare(strict_types = 1);
namespace KK\GeoIpHandler\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use GeoIp2\Database\Reader;
use TYPO3\CMS\Core\Database\ConnectionPool;

class RedirectionMiddleware implements MiddlewareInterface
{
    /**
     * Adds an instance of TYPO3\CMS\Core\Http\NormalizedParams as
     * attribute to $request object
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
        try{
            $requestUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];

            
            $extPath = ExtensionManagementUtility::extPath('geo_ip_handler');
            $reader = new Reader($extPath.'Resources/Public/GeoLite/GeoLite2-City.mmdb');
            $currentIp = GeneralUtility::getIndpEnv('REMOTE_ADDR');
            
            $record = $reader->city($currentIp);
            $isoCode = $record->country->isoCode ;
            
            // Get redirect matching with current isocode
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_geoiphandler_domain_model_redirect')
                ->select('isocode','target','trigger','skip_urls')
                ->from('tx_geoiphandler_domain_model_redirect');
            $queryBuilder->where(
                $queryBuilder->expr()->eq('isocode', $queryBuilder->createNamedParameter($isoCode))
            );
            $redirectRule = $queryBuilder->execute()->fetch();
            
            // If matching redirect found
            if($redirectRule){
                
                //if iso code of clients's ip exists in redirect rule               
                $target = $redirectRule['target'];
                $trigger = $redirectRule['trigger'];
                $referrerArray = explode(',',$redirectRule['skip_urls']);
                if( $trigger === 'in' ){

                    if(is_array($referrerArray) && !in_array($_SERVER['HTTP_HOST'], $referrerArray)){ 
                        if( $requestUrl != $target ){
                            HttpUtility::redirect($target);
                        }
                    }

                }
                elseif($trigger === 'out'){
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                        ->getQueryBuilderForTable('tx_geoiphandler_domain_model_redirect')
                        ->select('isocode','target','trigger')
                        ->from('tx_geoiphandler_domain_model_redirect');
                    $redirectRule = $queryBuilder->execute()->fetchAll();
                    if(is_array($referrerArray) && !in_array($_SERVER['HTTP_HOST'], $referrerArray)){ 
                        $this->redirectToTarget($redirectRule, strtolower($isoCode), $requestUrl);
                    }
                    
                }
            }
            else{
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getQueryBuilderForTable('tx_geoiphandler_domain_model_redirect')
                    ->select('isocode','target','trigger')
                    ->from('tx_geoiphandler_domain_model_redirect');
                $redirectRule = $queryBuilder->execute()->fetchAll();
                $this->redirectToTarget($redirectRule, strtolower($isoCode), $requestUrl);
            }

        }
        catch(\Exception $e) {
          echo $e->getMessage();
        }

        if ($response) {
            return $response;
        }

        $response = $handler->handle($request);
        return $response;
    }


    /**
    * function redirectToTarget
    * This function redirects to the target if iso of client's ip not exists in rules or value for trigger of the rule is 'out'
    *
    **/
    public function redirectToTarget($rules, string $iso, string $requestUrl){
        foreach ($rules as $key => $rule) {
            $target = $rule['target'];
            $trigger = $rule['trigger'];
            $isocode = $rule['isocode'];
            if($isoCode != $isocode){
                if( $trigger == 'out' ){
                    if( $requestUrl != $target ){
                        HttpUtility::redirect($target);
                        break;
                    }
                }
            }
        }
    }
}