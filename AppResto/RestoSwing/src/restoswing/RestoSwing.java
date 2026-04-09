package restoswing;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */

/**
 *
 * @author puelm
 */
public class RestoSwing extends javax.swing.JFrame {
    
    private static final java.util.logging.Logger logger = java.util.logging.Logger.getLogger(RestoSwing.class.getName());

    /**
     * Creates new form Main
     */
    public RestoSwing() {
        initComponents();
        chargerCommandes();

        // Bouton Quitter : ferme l'application
        jButton5.addActionListener(e -> System.exit(0));

        // Bouton Détails : ouvre une fenêtre avec les lignes de la commande sélectionnée
        jButton3.addActionListener(e -> {
            int ligne = jTable.getSelectedRow();
            if (ligne == -1) {
                javax.swing.JOptionPane.showMessageDialog(this, "Sélectionnez une commande d'abord.");
                return;
            }
            int idCommande = (int) jTable.getModel().getValueAt(ligne, 0);
            afficherDetails(idCommande);
        });
    }

    // Charge les commandes en attente depuis l'API et remplit le JTable
    private void chargerCommandes() {
        try {
            java.net.URL url = new java.net.URL("http://localhost/Projets/RepoProjectBTS/RestoWeb/Site/api/commande_en_attente.php");
            java.net.HttpURLConnection conn = (java.net.HttpURLConnection) url.openConnection();
            conn.setRequestMethod("GET");

            java.io.BufferedReader reader = new java.io.BufferedReader(
                new java.io.InputStreamReader(conn.getInputStream())
            );
            StringBuilder sb = new StringBuilder();
            String line;
            while ((line = reader.readLine()) != null) {
                sb.append(line);
            }
            reader.close();

            org.json.JSONArray tableau = new org.json.JSONArray(sb.toString());

            String[] colonnes = {"ID", "Date", "Prix", "Type", "Etat", "Client ID"};
            Object[][] data = new Object[tableau.length()][6];

            for (int i = 0; i < tableau.length(); i++) {
                org.json.JSONObject commande = tableau.getJSONObject(i);
                data[i][0] = commande.getInt("id");
                data[i][1] = commande.getString("date");
                data[i][2] = commande.getDouble("prix");
                data[i][3] = commande.getString("type");
                data[i][4] = commande.getInt("etat");
                data[i][5] = commande.getInt("idUtil");
            }

            javax.swing.table.DefaultTableModel model = new javax.swing.table.DefaultTableModel(data, colonnes);
            jTable.setModel(model);

        } catch (Exception ex) {
            javax.swing.JOptionPane.showMessageDialog(this, "Erreur de connexion à l'API : " + ex.getMessage());
        }
    }

    // Ouvre une JDialog avec les détails (lignes) de la commande sélectionnée
    private void afficherDetails(int idCommande) {
        try {
            java.net.URL url = new java.net.URL(
                "http://localhost/Projets/RepoProjectBTS/RestoWeb/Site/api/commande_detail.php?id_commande=" + idCommande
            );
            java.net.HttpURLConnection conn = (java.net.HttpURLConnection) url.openConnection();
            conn.setRequestMethod("GET");

            java.io.BufferedReader reader = new java.io.BufferedReader(
                new java.io.InputStreamReader(conn.getInputStream())
            );
            StringBuilder sb = new StringBuilder();
            String line;
            while ((line = reader.readLine()) != null) {
                sb.append(line);
            }
            reader.close();

            org.json.JSONArray tableau = new org.json.JSONArray(sb.toString());

            String[] colonnes = {"Produit", "Quantité", "Prix HT"};
            Object[][] data = new Object[tableau.length()][3];

            for (int i = 0; i < tableau.length(); i++) {
                org.json.JSONObject ligneObj = tableau.getJSONObject(i);
                data[i][0] = ligneObj.getString("libProduit");
                data[i][1] = ligneObj.getInt("qteCommandee");
                data[i][2] = ligneObj.getDouble("prixHtLigneCommande");
            }

            javax.swing.table.DefaultTableModel model = new javax.swing.table.DefaultTableModel(data, colonnes);
            javax.swing.JTable tableDetails = new javax.swing.JTable(model);
            javax.swing.JScrollPane scroll = new javax.swing.JScrollPane(tableDetails);

            javax.swing.JDialog dialog = new javax.swing.JDialog(this, "Détails commande #" + idCommande, true);
            dialog.add(scroll);
            dialog.setSize(400, 300);
            dialog.setLocationRelativeTo(this);
            dialog.setVisible(true);

        } catch (Exception ex) {
            javax.swing.JOptionPane.showMessageDialog(this, "Erreur de connexion à l'API : " + ex.getMessage());
        }
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane1 = new javax.swing.JScrollPane();
        jTable = new javax.swing.JTable();
        jButton3 = new javax.swing.JButton();
        jButton5 = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jTable.setModel(new javax.swing.table.DefaultTableModel(
            new Object [][] {
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null}
            },
            new String [] {
                "Title 1", "Title 2", "Title 3", "Title 4"
            }
        ));
        jScrollPane1.setViewportView(jTable);

        jButton3.setText("Details");

        jButton5.setText("Quitter");

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(68, 68, 68)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(jButton5)
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 489, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 115, Short.MAX_VALUE)
                .addComponent(jButton3)
                .addGap(93, 93, 93))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(83, 83, 83)
                        .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 357, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(137, 137, 137)
                        .addComponent(jButton3)))
                .addGap(18, 18, 18)
                .addComponent(jButton5)
                .addContainerGap(114, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ReflectiveOperationException | javax.swing.UnsupportedLookAndFeelException ex) {
            logger.log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(() -> new RestoSwing().setVisible(true));
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButton3;
    private javax.swing.JButton jButton5;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JTable jTable;
    // End of variables declaration//GEN-END:variables
}
