<?php
/**
 * @link https://github.com/XRayLP/learning-center-bundle
 * @copyright Copyright (c) 2018 Niklas Loos <https://github.com/XRayLP>
 * @license GPL-3.0 <https://github.com/XRayLP/learning-center-bundle/blob/master/LICENSE>
 */

namespace App\XRayLP\LearningCenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\XRayLP\LearningCenterBundle\Entity\Member;
use App\XRayLP\LearningCenterBundle\Entity\MemberGroup;
use App\XRayLP\LearningCenterBundle\Member\FrontendMember;

class LearningCenterController extends Controller
{

    /**
     * SOON: Dashboard
     *
     * @return RedirectResponse|Response
     */
    public function mainAction()
    {
        //Check if the User isn't granted
        if ($this->get('security.authorization_checker')->isGranted('ROLE_MEMBER'))
        {

            $member = $this->getDoctrine()->getRepository(Member::class)->findOneBy(array('id' => $this->getUser()->id));


            $rendered = $this->renderView('@LearningCenter/modules/dashboard.html.twig', array(
                'name' => $member->getFirstname().' '.$member->getLastname(),
                'schoolname' => 'Stephaneum',
            ));
            return new Response($rendered);

        } else {
            return $this->redirectToRoute('learningcenter_login');
        }

    }


    /**
     * Redirect URLs with a Trailing Slash
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo   = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);

    }
}