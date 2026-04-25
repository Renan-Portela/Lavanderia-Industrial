# Research: Industrial Washing Standards & SKU Strategy

## Overview
This document consolidates research on industrial washing patterns for PPE (EPI) and industrial cloths to ensure market readiness and process integrity.

## 1. Professional PPE (EPI) Washing Standards

### Leather and "Raspa" (Split Leather)
- **Standard**: Dry Cleaning (Lavagem a Seco) only.
- **Decision**: All items made of leather or "raspa" (gloves, aprons, sleeves) MUST be dry cleaned using organic solvents (Perc/Hydrocarbon).
- **Rationale**: Water washing strips natural oils, causing hardening, shrinking, and permanent loss of protective integrity (Reference: ABNT NBR 16295, ISO 15797).
- **Alternatives**: Water washing with specific oils (too expensive and complex for this scale).

### General Industrial PPE
- **Helmets**: Hand wash with neutral soap and water (<40°C). NO machine wash.
- **Boots (PVC/Rubber)**: Industrial water wash with sanitizing agents.
- **Aprons (PVC/Nylon)**: Industrial water wash (40°C-60°C).

## 2. Industrial Cloth Color Coding
- **Blue (Azul)**: General Industry (Maintenance, machinery).
- **Red (Vermelho)**: Print Shops (Grafica) / Hazardous (Inks, solvents).
- **Green (Verde)**: Assembly/Precision (Clean areas, electronics).

## 3. SKU Strategy [CAT]-[MAT]-[SIZ]

### Pattern: `[CAT]-[MAT]-[SIZ]`
- **CAT (Category)**:
  - `GLV`: Glove (Luva)
  - `APR`: Apron (Avental)
  - `HLM`: Helmet (Capacete)
  - `BTT`: Boot (Bota)
  - `CLO`: Cloth (Pano)
  - `SLV`: Sleeve (Mangote)
- **MAT (Material)**:
  - `RSP`: Raspa
  - `LTH`: Leather (Couro)
  - `PVC`: PVC
  - `NYL`: Nylon
  - `COT`: Cotton (Algodão)
  - `BLU`: Blue (for cloths)
  - `RED`: Red (for cloths)
  - `GRN`: Green (for cloths)
- **SIZ (Size)**:
  - `UNI`: Universal
  - `P/M/G/GG`: Standard sizes
  - `038-045`: Numeric sizes for boots

### Examples:
- `GLV-RSP-GG`: Glove, Raspa, Extra Large.
- `CLO-BLU-UNI`: Cloth, Blue, Universal.
- `BTT-PVC-042`: Boot, PVC, Size 42.

## 4. Architectural Decisions

### Washing Method Placement
- **Decision**: Stored as a property of the **Material (SKU)**.
- **Rationale**: The material composition dictates the washing method (e.g., Raspa must never touch water). Storing it at the SKU level ensures process integrity and prevents operator error during the receiving/washing transition.
- **Alternatives**: Order-level property (rejected because it risks human error during entry).
