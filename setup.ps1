# Define the main folder
$mainFolder = "Livrable"

# Define subfolders and files
$folders = @(
    "Cahier des Charges",
    "Conception UML",
    "Maquette",
    "Maquette\Fichier source de la maquette"
)

$files = @(
    "Cahier des Charges\Cahier des Charges.docx",
    "Cahier des Charges\Cahier des Charges.pdf",
    "Conception UML\Diagrammes UML (Use Case, Classe).pdf",
    "Maquette\Maquette Desktop.pdf",
    "Maquette\Maquette Mobile.pdf",
    "Maquette\Fichier source de la maquette\AdobeXD_Lien.txt"
)

# Create main folder
New-Item -Path $mainFolder -ItemType Directory -Force

# Create subfolders
foreach ($folder in $folders) {
    New-Item -Path "$mainFolder\$folder" -ItemType Directory -Force
}

# Create empty files
foreach ($file in $files) {
    New-Item -Path "$mainFolder\$file" -ItemType File -Force
}

Write-Host "Folder structure successfully created in: $mainFolder"
