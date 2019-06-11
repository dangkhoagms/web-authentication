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

***document***
https://symfony.com/doc/current/security/form_login_setup.html  
    
# SCRIPT

### 1. script create AUTH
    bin/console make:auth
