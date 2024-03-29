# NOTE

### 1. working auth

    class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
    {
        /**
         * @var UserRepository
         */
        private $repository;
        /**
         * @var RouterInterface
         */
        private $router;
    
        public function __construct(UserRepository $repository, RouterInterface $router)
        {
    
            $this->repository = $repository;
            $this->router = $router;
        }
    
        public function supports(Request $request)
        {
            return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
        }
    
        public function getCredentials(Request $request)
        {
            $credentials =  [
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password')
            ];
            $request->getSession()->set(
               Security::LAST_USERNAME,
                $credentials['email']
            );
            return $credentials;
        }
    
        public function getUser($credentials, UserProviderInterface $userProvider)
        {
            return $this->repository->findOneBy(['email'=>$credentials['email']]);
        }
    
        public function checkCredentials($credentials, UserInterface $user)
        {
          return true;
        }
    
        public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
        {
            if($request->hasSession()){
                $request->getSession()->set(Security::AUTHENTICATION_ERROR,$exception);
    
            }
    
            return new RedirectResponse($this->router->generate('app_login'));
        }
    
        public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
        {
          //  dd($this->router);
            return new RedirectResponse($this->router->generate('article_index'));
        }
    
        public function start(Request $request, AuthenticationException $authException = null)
        {
            // todo
        }
    
        public function supportsRememberMe()
        {
            // todo
        }
    
        /**
         * Return the URL to the login page.
         *
         * @return string
         */
        protected function getLoginUrl()
        {
            // TODO: Implement getLoginUrl() method.
        }
    }
***sercurity.yaml***

    security:
        # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
        providers:
            # used to reload user from session & other features (e.g. switch_user)
            app_user_provider:
                entity:
                    class: App\Entity\User
                    property: email
        firewalls:
            dev:
                pattern: ^/(_(profiler|wdt)|css|images|js)/
                security: false
            main:
                anonymous: true
                guard:
                    authenticators:
                        - App\Security\LoginFormAuthenticator
    
                logout:
                    path: app_logout
                # activate different ways to authenticate
                # https://symfony.com/doc/current/security.html#firewalls-authentication
    
                # https://symfony.com/doc/current/security/impersonating_user.html
                # switch_user: true
    
        # Easy way to control access for large sections of your site
        # Note: Only the *first* access control that matches will be used
        access_control:
            # - { path: ^/admin, roles: ROLE_ADMIN }
            # - { path: ^/profile, roles: ROLE_USER }
***controller***

    class LoginController extends AbstractController
    {
        /**
         * @Route("/login", name="app_login")
         */
        public function index(AuthenticationUtils $authenticationUtils)
        {
    
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUserName = $authenticationUtils->getLastUsername();
            return $this->render('login/index.html.twig', [
                'controller_name' => 'LoginController',
                'error' => $error,
                'last_username' => $lastUserName
            ]);
        }
    
        /**
         * @Route("/logout",name="app_logout")
         */
        public function logout()
        {
            throw new \Exception("Will be intercepted before getting here");
        }
    }


***document***
https://symfony.com/doc/current/security/form_login_setup.html  

### 2. working rememberme

***template***
   
    <input type="checkbox" id="remember_me" name="_remember_me" />
***sercurity.yaml***
    
    
      remember_me:
        secret:   '%kernel.secret%'
        lifetime: 2592000 # 30 days in seconds

### 3. working access with security
    
    access_control:
      - { path: ^/article, roles: ROLE_ADMIN }

1. if you wanted to force EVERY URL to be protected
 use IS_AUTHENTICATED_FULLY
2. if definitely allow /login to be accessible anonymously
use IS_AUTHENTICATED_ANONYMOUSLY	
### 4. working current user

***create BaseController***

    abstract class BaseController extends AbstractController
    {
        protected function getUser():User
        {
            return parent::getUser();
        }
    
    
    }
    
***AccountController***

    /**
     * Class AccountController
     * @IsGranted("ROLE_USER")
     */
    class AccountController extends BaseController
    {
        /**
         * @Route("/account", name="app_account")
         */
        public function index(LoggerInterface $logger)
        {
            $logger->debug('Checking account page for '.$this->getUser()->getEmail());
            return $this->render('account/index.html.twig', [
                'controller_name' => 'AccountController',
            ]);
        }
    }

### 5. add method Entity

    public function  getAvatarUrl(string $size = null):string {
            $url = "https://robohash.org/".$this->getEmail();
            if($size){
                $url.=sprintf('?size=%dx%d',$size,$size);
            }
            return $url;
        }
 template using
    
    <img src="{{ app.user.avatarUrl(150) }}" />

### 6. Working sercurity.yaml
***config config/packages/security.yaml***  

    role_hierarchy:
            ROLE_ADMIN: [ROLE_ADMIN_COMMENT,ROLE_ADMIN_ARTICLE]
***Swich user***
    
    switch_user : true
add add ROLE_ALLOWED_TO_SWITCH

    role_hierarchy:
            ROLE_ADMIN: [ROLE_ADMIN_COMMENT,ROLE_ADMIN_ARTICLE,ROLE_ALLOWED_TO_SWITCH]
                
    
# SCRIPT

### 1. script create AUTH
    bin/console make:auth
