<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ProdutoController extends Controller
{
    /**
     * @Route("/produto", name="listar_produto")
     * @Template ("produto/index.html.twig")
     *
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager(); //acessar o banco
        $produtos = $em->getRepository(Produto::class)->findAll();

        return [
            'produtos' => $produtos  //coleção de produtos será exbido na view
        ];
    }

    /**
     * @param Request $request
     * @Route ("/produto/cadastrar", name="cadastrar_produto")
     * @Template ("produto/create.html.twig")
     * @return Response
     */

    public function create(Request $request)
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);

        $form->handleRequest($request); //para fazer a validação pelo validator tem q tratar da requisição

        //processo para salvar. Veja abaixo - persistência

        if ($form->isSubmitted() && $form->isValid()) { //enviado e válido
            $em = $this->getDoctrine()->getManager();
            $em->persist($produto);
            $em->flush();

            //$this->get('session')->getFlashBag()->set('success', 'produto foi salvo com sucesso'); //passar no index
            $this->addFlash('success', 'produto foi salvo com sucesso');
            return $this->redirectToRoute('listar_produto');
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @Route ("/produto/editar/{id}", name="editar_produto")
     * @Template ("produto/update.html.twig")
     * @return Response
     */

    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //enviado e válido
            $em->persist($produto);
            $em->flush();

            //$this->get('session')->getFlashBag()->set('success', 'produto foi salvo com sucesso'); //passar no index
            $this->addFlash('success', "o produto " . $produto->getNome() . " foi alterado com sucesso");
            return $this->redirectToRoute('listar_produto');
        }
        return [
            'produto' => $produto,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @Route ("produto/visualizar/{id}", name="visualizar_produto")
     * @Template ("produto/view.html.twig")
     * @return Response
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);
        return [
            'produto' => $produto
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @Route ("produto/apagar/{id}", name="deletar_produto")
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        if (!$produto) {
            $mensagem = "Produto não foi encontrado";
            $tipo = "warning";
        } else {
            $em->remove($produto);
            $em->flush();
            $mensagem = "produto excluído com sucesso!!!";
            $tipo = "success";
        }
        $this->get('session')->getFlashBag()->set($tipo, $mensagem);
        return $this->redirectToRoute("listar_produto");

    }

}
