<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CustomerController extends AbstractController
{
    #[Route('api/customers', name: 'app_api_customers', methods:['GET'])]
    public function index(CustomerRepository $customerRepository): JsonResponse
    {
        $data = $customerRepository->findAll();
        return $this->json($data,200,[], ["groups"=>['customer','contractLinked']] );
    }

    #[Route('api/customers/{id}', name: 'app_api_customers_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(customer $customer): JsonResponse
    {
        return $this->json($customer, Response::HTTP_OK,[], ["groups"=>['customer','contractLinked']] );
    }


    #[Route('api/customers/delete/{id}', name: 'app_api_customers_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(customer $customer, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($customer);
        $em->flush();
        return $this->json([
            "success" =>["item deleted"]],Response::HTTP_NO_CONTENT);
    }

    #[Route('api/customers/create', name: 'app_api_customers_create', methods:['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em , ValidatorInterface $validator): JsonResponse
     
    {
        $data = $request->getContent();
        $customer = $serializer->deserialize($data, Customer::class, 'json');
        //  check if the data are in the right format
        try {
            $customer = $serializer->deserialize($data, Customer::class, 'json');
        } catch (NotEncodableValueException $exception) {
            return $this->json([
                "error" =>
                ["message" => $exception->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }
        //  check if the data respect the validation constraints
        $errors = $validator->validate($customer);
        if (count($errors) > 0) {
            $dataErrors = [];
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(["error" => ["message" => $dataErrors]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $em->persist($customer);
        $em->flush();
        return $this->json(
        $customer, 
        Response::HTTP_CREATED, 
        ["Location" => $this->generateUrl("app_api_customers")]
        ); 
    }
#[Route('api/customers/edit/{id}', name: 'app_api_customers_edit', methods: ['GET'])]
public function edit(Customer $customer): JsonResponse
{
    if (!$customer) {
        return $this->json([
            "fail" => ["this customer doesn't exist"]
        ], Response::HTTP_NOT_FOUND);
    }
    return $this->json(
        $customer, 
        Response::HTTP_OK, 
        [], 
        ["groups"=>['customer','contractLinked']] 
    );
}

#[Route('api/customers/update/{id}', name:"app_api_customers_update", methods:['POST'])]

    public function update(Request $request, SerializerInterface $serializer, Customer $currentCustomer, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse 

        {
            // Check if the customer exists
            if (!$currentCustomer) {
                throw $this->createNotFoundException('Le client n\'existe pas.');
            }
            // Convert the JSON in Doctrine Object
            $updatedCustomer = $serializer->deserialize($request->getContent(), 
                Customer::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentCustomer]);
            // We check if we received a JSON
            try {
                //we catch the JSON in the request
                    $updatedCustomer = $serializer->deserialize($request->getContent(),
                    Customer::class, 
                        'json', 
                        [AbstractNormalizer::OBJECT_TO_POPULATE => $currentCustomer]);
                }
            catch (NotEncodableValueException $exception) {
                
                return $this->json([
                    "error" =>
                    ["message" => $exception->getMessage()]
                ], Response::HTTP_BAD_REQUEST);
            }
            // we check if there is error
            $errors = $validator->validate($updatedCustomer);
            if (count($errors) > 0) {

                $dataErrors = [];
                
                foreach ($errors as $error) {
                    
                $dataErrors[$error->getPropertyPath()] = $error->getMessage();
                }
            }
            // Persist and flush the changes in database
            $em->persist($updatedCustomer);
            $em->flush();
            // Return the CREATED JSON response
            return $this->json($updatedCustomer, 
            Response::HTTP_CREATED,
            ["Location" => $this->generateUrl("app_api_customers")],
            ["groups"=>['customer','contractLinked']] 
        );
        
   }
}