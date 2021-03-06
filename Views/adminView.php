<?php require_once "headerAdmin.php";
require_once "Models/admin.php";

echo '<div class="d-flex justify-content-center"> <h3> Bonjour Administrateur ' . $_SESSION['login'] . ' ! </h3></div>';


$data = listData($pdo);?>

    <table class="container">
        <thead class="header-tab">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Mail expéditeur</th>
                <th scope="col">Mail destinataire</th>
                <th scope="col">Zip</th>
                <th scope="col">Sujet</th>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($data)) : ?>

                <tr>
                    <td colspan="12" class="container no-result">Aucun résultat trouvé</td>
                </tr>

            <?php else :
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    //on vérifie que l'id existe dans la BDD
                    $result = siExist($pdo, $_GET['id']);
                    //s'il existe on le delete de la BDD
                    if ($result['0']['zip'] != null) {
                        delete($pdo);
                        //On supprime le fichier du serveur
                        $deleteZip = deleteFile($result['0']['zip']);
                        //on reverifie qu'il n'existe plus dans la BDD
                        $result = siExist($pdo, $_GET['id']);
                        //si la suppression a échoué on affiche un message
                        if(!empty($result)){
                            echo 'Une erreur est survenue pendant la suppression des données de la BDD';  
                        } else {
                            echo 'l\'élément avec l\'id :' . $_GET['id'] . ' à bien été supprimé de la BDD!';
                            //On affiche le resultat de la suppression du fichier
                            echo $deleteZip;  
                        }
                        //Si la suppression a échoué on affiche un message
                    } else {
                        echo 'Veuillez vérifier votre ID car il n\'existe pas dans la base de données';
                    }
                    //Affiche la BDD actuel
                    $listEntree = numberTab(listData($pdo));
                    $page = new Page($listEntree );
                    echo $page->page();
                    //////////////////////////////////////////////
                    //$listData = listData($pdo);
                    
                } else {
                    //Affiche la BDD après suppression
                    //$listData = listData($pdo);
                    $listEntree = numberTab(listData($pdo));
                    $page = new Page($listEntree );
                    echo $page->page();
                    

                    
                    ///////////////////////////////////////////
                    //checkList($data);
                    
                }
            ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php require_once "footerAdminView.php"; ?>