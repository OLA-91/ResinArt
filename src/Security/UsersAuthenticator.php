<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
class UsersAuthenticator extends AbstractLoginFormAuthenticator
{
    // permet de gérer la redirection vers une URL cible après l'authentification.
    use TargetPathTrait; 

    public const LOGIN_ROUTE = 'app_login';

    // Le constructeur de la classe, l'interface  pour faire les génération  de URLs.
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }
    //  methode return a passport gerer l'authentification de l'utilisateur
    public function authenticate(Request $request): Passport
    { //recupere la valeur mail
        $email = $request->request->get('email', '');
    //ادخال اخر مستخدم كتبناه
        $request->getSession()->set(Security::LAST_USERNAME, $email);
    // السماح بالبحث عن المستخدم من خلال الايميل و استرجاع كلمة السر 
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                //التحقق من الفورم
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }
    //اذا كان ال autheتعمل
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
    //رجوع المستخدم للصفحة التي اتصل منها
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

    // For example: mainاعادة توجيه المستخدم الي 
         return new RedirectResponse($this->urlGenerator->generate('main'));
    // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
