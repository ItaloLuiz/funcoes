<?php 

/*
 Trabalhando com a captura de emails percebi que as vezes
 as pessoas digitam de forma incorreta o nome do servidor, 
 por exemplo: gmil ao invés de gmail.

 Também tive alguns problemas com pessoas colocando espaços no email
 e um ponto logo no inicio.

 Problemas que podem em parte ser resolvidos com a emailable,
 mas ela é um pouco salgada, por isso fiz essas funções básicas para
 ajudar um pouco.

 Ainda precisa ser refatorada.


*/

$email = 'italo.luis.s@Uol.c';


function serverLists()
{
    $servers = array(
        'gmail.com',
        'yahoo.com',
        'yahoo.com.br',
        'hotmail.com',
        'hotmail.com.br',
        'outlook.com',
        'bol.com.br',
        'uol.com.br'
    );
    return $servers;
}

function normalizarEmail($email)
{
    $email = trim($email);
    $isso = array(' ');
    $por  = array('');

    $primeiro_caracter = mb_substr($email, 0, 1);

    if($primeiro_caracter == '.'){
        $email = substr($email,1);
    } else{
        $email =$email; 
    } 
    $substr = str_replace($isso,$por,$email);
    return $substr;
}

function validarMx($servidor)
{
    //type pode ser: A, MX, NS, SOA, PTR, CNAME, AAAA, A6, SRV, NAPTR, TXT or ANY.
    $checar_mx = checkdnsrr($servidor, 'MX');
    if($checar_mx == false){
        $dados = array(
            'error_mx' => true,
            'email_digitado' => false,
            'email_valido' => false,
            'email_sugerido' => false
        );
        echo json_encode($dados);
        exit;
    }
}

function similarEmails($email)
{
    //normalizar o email antes de checar sua validade
    $email = normalizarEmail($email);    
    //checar se o que foi digitado é um email
    $email_sanatized = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email_sanatized, FILTER_VALIDATE_EMAIL)) {        
        $dados = array(
            'error_mx' => false,
            'email_digitado' => $email,
            'email_valido' => false,
            'email_sugerido' => false  
           );
        return json_encode($dados);
        exit;
    }    
    //pegar o servidor do email
    $explode_email  = explode('@',$email);
    $servidor_email = strtolower($explode_email[1]);  

    $listar_servers_emails = serverLists();
    $valid = true;

    if(!(in_array($servidor_email,$listar_servers_emails)))
    {
        $valid = false;
        //checar similaridade de termos
        $forcar_array = [];
        foreach($listar_servers_emails as $server){
            $similaridade = similar_text($servidor_email,$server);
            $forcar_array2 = array(
                'error_mx' => false,
                'email_informado'  => $servidor_email,
                'servidor'         => $server,
                'similaridade'     => $similaridade
            ); 
            array_push($forcar_array,$forcar_array2);            
        }

        $numero_similaridade = '';       
        $servidor_sugerido   = '';
        foreach($forcar_array as $dados){
            $numero_similaridade .= $dados['similaridade'].',';           
            $servidor_sugerido   .= strtolower($dados['servidor']).',';
        }

        $numero_similaridade =  explode(',',substr($numero_similaridade,0,-1));       
        $servidor_sugerido   =  explode(',',substr($servidor_sugerido,0,-1));

        $provavel_servidor = max($numero_similaridade); 
        $key = array_search($provavel_servidor,$numero_similaridade);
        $servidor_sugerido[$key];

        //validação extra com mx
        validarMx($servidor_sugerido[$key]);

       $dados = array(
        'error_mx' => false,
        'email_digitado' => $email,
        'email_valido' => $valid,
        'email_sugerido' => $explode_email[0].'@'.$servidor_sugerido[$key]  
       );
       return json_encode($dados); 

    }else{
        $dados = array(
            'error_mx' => false,
            'email_digitado' => $email,
            'email_valido' => $valid,
            'email_sugerido' => false  
           );
           return json_encode($dados); 
    }

  

}

echo similarEmails($email);
