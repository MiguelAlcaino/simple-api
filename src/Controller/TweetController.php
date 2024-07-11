<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tweet;
use App\Repository\TweetRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TweetController extends AbstractController
{
    #[Route('/tweets', name: 'tweet_list', methods: ['GET'])]
    public function allTweets(TweetRepository $tweetRepository): JsonResponse
    {
        $tweets      = $tweetRepository->findAllFromNewest();
        $tweetsArray = array_map(fn($tweet) => $this->transformTweetToArray($tweet), $tweets);

        return new JsonResponse($tweetsArray);
    }

    private function transformTweetToArray(Tweet $tweet): array
    {
        return [
            'id'        => $tweet->getId(),
            'username'  => $tweet->getUsername(),
            'tweetBody' => $tweet->getTweetBody(),
            'createdAt' => $tweet->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    #[Route('/tweets', name: 'tweet_submit', methods: ['POST'])]
    public function submitTweet(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data  = json_decode($request->getContent(), true);
        $tweet = new Tweet();
        $tweet->setTweetBody($data['tweetBody'])->setUsername($data['username'])->setCreatedAt(new DateTimeImmutable());

        $em->persist($tweet);
        $em->flush();

        return new JsonResponse($this->transformTweetToArray($tweet));
    }

    #[Route('/tweets/{id}', name: 'tweet_update', methods: ['POST'])]
    public function updateTweet(int $id, Request $request, TweetRepository $tweetRepository, EntityManagerInterface $em): JsonResponse
    {
        $tweet = $tweetRepository->find($id);
        if (!$tweet) {
            return new JsonResponse(['error' => 'Tweet not found'], 404);
        }
        $data = json_decode($request->getContent(), true);
        $tweet->setTweetBody($data['tweetBody'])->setUsername($data['username']);
        $em->flush();

        return new JsonResponse($this->transformTweetToArray($tweet));
    }

    #[Route('/tweets/{id}', name: 'tweet_delete', methods: ['DELETE'])]
    public function deleteTweet(int $id, TweetRepository $tweetRepository, EntityManagerInterface $em): JsonResponse
    {
        $tweet = $tweetRepository->find($id);
        if (!$tweet) {
            return new JsonResponse(['error' => 'Tweet not found'], 404);
        }
        $em->remove($tweet);
        $em->flush();

        return new JsonResponse(['status' => 'Tweet deleted']);
    }
}
