<?php
$identificador = 'Probando2';
$variables_formulario = array (
  0 => 'nombre',
  1 => 'apellido',
);
$cargar_variables_formulario = true;
$atributos = array (
  0 => 'persona',
);
$tituloFormulario = 'Registro persona';
$tituloSalida = 'Registro exitoso';
?><?php require_once 'C:\Users\ado\Documents\NetBeansProjects\factory\data\servlet_multiple_form\FUNCIONES_PROYECTO.PHP';?>/* * To change this license header, choose License Headers in Project Properties. * To change this template file, choose Tools | Templates * and open the template in the editor. */package servlets;import dispatcher.Dispatcher;import java.io.IOException;import javax.servlet.ServletException;import javax.servlet.annotation.WebServlet;import javax.servlet.http.HttpServlet;import javax.servlet.http.HttpServletRequest;import javax.servlet.http.HttpServletResponse;/** * * @author ado */@WebServlet(name = "<?php echo ucfirst($identificador);?>", urlPatterns = {"/<?php echo $identificador;?>"})public class <?php echo ucfirst($identificador);?> extends HttpServlet {    /**     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>     * methods.     *     * @param request servlet request     * @param response servlet response     * @throws ServletException if a servlet-specific error occurs     * @throws IOException if an I/O error occurs     */    protected void processRequest(HttpServletRequest request, HttpServletResponse response)            throws ServletException, IOException {                try {<?php if($cargar_variables_formulario): ?>    <?php foreach($variables_formulario as $var): ?>            String <?php echo $var;?>="";    <?php endforeach; ?>    <?php foreach($variables_formulario as $var): ?>            request.setAttribute("<?php echo $var;?>", <?php echo $var;?>);    <?php endforeach; ?><?php endif;?>            Dispatcher.dispatch(request, response, "<?php echo $identificador;?>.jsp", "<?php echo $tituloFormulario;?>:");        } catch (Exception e) {            System.out.println("[Error]: " + e);        }            }    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">    /**     * Handles the HTTP <code>GET</code> method.     *     * @param request servlet request     * @param response servlet response     * @throws ServletException if a servlet-specific error occurs     * @throws IOException if an I/O error occurs     */    @Override    protected void doGet(HttpServletRequest request, HttpServletResponse response)            throws ServletException, IOException {        processRequest(request, response);    }    /**     * Handles the HTTP <code>POST</code> method.     *     * @param request servlet request     * @param response servlet response     * @throws ServletException if a servlet-specific error occurs     * @throws IOException if an I/O error occurs     */    @Override    protected void doPost(HttpServletRequest request, HttpServletResponse response)            throws ServletException, IOException {        processRequest(request, response);    }    /**     * Returns a short description of the servlet.     *     * @return a String containing servlet description     */    @Override    public String getServletInfo() {        return "Short description";    }// </editor-fold>}