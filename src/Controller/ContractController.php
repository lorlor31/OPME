<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Repository\ContractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class ContractController extends AbstractController
{
    #[Route('api/contracts', name: 'app_api_contracts', methods: ['GET'])]
    public function index(ContractRepository $contractRepository): JsonResponse
    {
        $data = $contractRepository->findAll();

        return $this->json(
            $data, 
            200, 
            [], 
            ["groups" => ['contract']]
        );
    }

    #[Route('api/contracts/{id}', name: 'app_api_contracts_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Contract $contract): JsonResponse
    {
        if (!$contract) {
            return $this->json([
                "fail" => ["this contract doesn't exist"]
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json(
            $contract, 
            Response::HTTP_OK, 
            [], 
            ["groups" => ['contract']]
        );          
    }

    #[Route('api/contracts/create', name: 'app_api_contracts_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // we catch the JSON in the request
        $data = $request->getContent();
        // we manage the case where the JSON is in the wrong format
        try {
            // we convert the JSON in contract object
            $contract = $serializer->deserialize($data, Contract::class, 'json');
        } catch (NotEncodableValueException $exception) {
            return $this->json([
                "error" =>
                ["message" => $exception->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Error checking
        $errors = $validator->validate($contract);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(
                ["error" => ["message" => $dataErrors]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $entityManager->persist($contract);
        $entityManager->flush();

        return $this->json(
            $contract, 
            Response::HTTP_OK, 
            [], 
            ["groups" => ['contract','customerLinked','userLinked','productLinked']]
        );
    }

    #[Route('api/contracts/delete/{id}', name: 'app_api_contracts_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Contract $contract, EntityManagerInterface $em): JsonResponse
    {
        // we catch the contract by the id and we use the remove from EntityManagerInterface
        $em->remove($contract);
        // we send the request to the database
        $em->flush();

        return $this->json([
            "success" => ["item deleted"]
        ], Response::HTTP_NO_CONTENT, ["Location" => $this->generateUrl("app_api_contracts")]);
    }

    #[Route('api/contracts/edit/{id}', name: 'app_api_contracts_edit', methods: ['GET'])]
    public function edit(Contract $contract): JsonResponse
    {
        if (!$contract) {
            return $this->json([
                "fail" => ["this contract doesn't exist"]
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->json(
            $contract, 
            Response::HTTP_OK, 
            [], 
            ["groups" => ['contract']]
        );
    }

    #[Route('api/contracts/update/{id}', name: "app_api_contracts_update", methods: ['POST'])]

    public function update(Request $request, SerializerInterface $serializer, Contract $currentContract, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {

        // {
        //     "id": 1,
        //     "type": "invoice",
        //     "ordered_at": null,
        //     "invoiced_at": null,
        //     "delivery_address": "67 av de la mairie",
        //     "status": "obsolete",
        //     "comment": "Je veux un chiot dessiné sur la casquette",
        //     "created_at": "2024-03-28T04:25:48+00:00",
        //     "updated_at": null,
        //     "user": 5
        //     ,
        //     "customer": 21,
        //     "products": [
        //         1
        //     ]
        // }

        //check if there is a contract with $id as id
        if (!$currentContract) {
            return $this->json([
                "fail" => ["this contract doesn't exist"]
            ], Response::HTTP_NOT_FOUND);
        }
        //check it there are at least one product in the contract
        $products = json_decode($request->getContent(), true)['products']; 
        $type = json_decode($request->getContent(), true)['type']; 
        if (count($products)==0) {
            if ($type=='invoice' || $type=='order' ) {
                return $this->json([
                    "Warning" => ["You can not pass the contract into an invoice or an order as long as you don't have products"]
                ], Response::HTTP_NOT_FOUND);
            }
        }
        // dd($products);
        // Convert the string Json to Json object
        $jsonReceived = json_decode($request->getContent(), true); 
        // convert the json formatted ids to simple integers for user, customer and products json
        $userId= $jsonReceived['user'] ;
        $customerId= $jsonReceived['customer'] ;
        $jsonReceived['user']=$userId ;
        $jsonReceived['customer']=$customerId ;
        // Given products is an array, loop to retrieve all the products'ids
        $productsId= [] ;
        foreach ($jsonReceived['products'] as $product) {
            $productsId[]=$product;
        }
        $jsonReceived['products']=$productsId ;
        // Convert the json object to string back
        $jsonToConvert=json_encode($jsonReceived) ;
    
        try {
            //Convert the json to an object to update
            $updatedContract = $serializer->deserialize(
                $jsonToConvert,
                Contract::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentContract]
            );
        } 
        
        catch (NotEncodableValueException $exception) {
            return $this->json([
                "error" =>
                ["message" => $exception->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }
        // Errors checking
        $errors = $validator->validate($updatedContract);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }
        }
        // Persist and flush the changes in the DB
        $em->persist($updatedContract);
        $em->flush();
        return $this->json(
            $updatedContract, 
            Response::HTTP_CREATED, 
            ["Location" => $this->generateUrl("app_api_contracts")],
            // ["groups" => ['contract', 'userLinked', 'customerLinked', 'productLinked','embroideryLinked']]
            //TODO check if it is ok without other groups
            ["groups" => ['contract']]
        );
    }

    #[Route('api/contracts/type/{type}', name: 'app_api_contracts_type', methods: ['GET'], requirements: ['type' => 'order|quotation|invoice'])]
    public function findByType(ContractRepository $contractRepository,$type): JsonResponse
    {
        $data = $contractRepository->findByType($type);

        return $this->json(
            $data, 
            200, 
            [], 
            ["groups" => ['contract']]
        );
    }

    #[Route('api/contracts/customer/{name}', name: 'app_api_contracts_customer', methods: ['GET'], requirements: ['name' => '[a-zA-Z]+'])]
    public function findByCustomer(ContractRepository $contractRepository,$name): JsonResponse
    {
        $data = $contractRepository->findContractsByCustomerName($name);

        return $this->json(
            $data, 
            200, 
            [], 
            ["groups" => ['contract']]
        );
    }
}
