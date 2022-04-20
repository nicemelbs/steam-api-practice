<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exceptions\NotFoundException;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;
use app\models\News;
use app\models\User;

class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }


    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());

            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thank you. We\'ll get back to you shortly');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact,
            'title' => 'Contact us'
        ]);
    }

    public function profile(Request $request, Response $response)
    {
        $params = $request->getRouteParams();
        $user = User::findById($params['id']);
        return $this->render('profile', [
            'user' => $user,
            'title' => $user ? $user->getDisplayName() : ''
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function news(Request $request, Response $response)
    {
        $params = $request->getRouteParams();
        $news = News::findById($params['id']);

        if (!$news) {
            throw new NotFoundException();
        }

        return $this->render('news', [
            'news' => $news,
            'title' => $news->title
        ]);
    }

    public function allNews(Request $request, Response $response)
    {
        {
            $allNews = News::findAll();
            return $this->render('all-news', [
                'allNews' => $allNews
            ]);
        }

    }
}