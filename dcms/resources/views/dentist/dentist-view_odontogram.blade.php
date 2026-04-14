@extends('layouts.dentist')

@section('title', '3D Procedure Odontogram | PUP Taguig Dental Clinic')

@section('styles')
<style>
  /* ── HIDE SIDEBAR & FULL WIDTH OVERRIDES ── */
  #sidebar, .sidebar { display: none !important; }

  #mainContent, main {
    margin-left: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    padding-top: 1.5rem !important;
    background-color: #F8FAFC; 
  }

  .glass-panel {
    background: white;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
  }

  /* 3D Canvas Container */
  #canvas-container {
    width: 100%;
    height: 600px; 
    border-radius: 12px;
    overflow: hidden;
    cursor: grab;
    position: relative;
  }
  #canvas-container:active {
    cursor: grabbing;
  }
</style>
@endsection

@section('content')
@php
  use Carbon\Carbon;
  // Gumawa ako ng fallback kung sakaling walang pangalan
  $patientName = $patient->name ?? 'Unknown Patient';
  $today = Carbon::now()->format('F d, Y');
  $currentTime = Carbon::now()->format('H:i');
@endphp

<div class="px-4 md:px-8 pb-10 max-w-[1600px] mx-auto fade-in">
  
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    
    <a href="{{ route('dentist.dentist.patient.profile', $patient->id ?? 1) }}" 
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-xl font-bold transition shadow-sm flex-shrink-0">
      <i class="fa-solid fa-xmark"></i> Cancel Procedure
    </a>

    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto flex-1 justify-end">
      
      <div class="glass-panel px-6 py-4 min-w-[200px] flex flex-col justify-center">
        <h2 class="text-2xl font-extrabold text-[#8B0000] leading-none mb-1">3D Tooth Chart</h2>
        <p class="text-sm font-medium text-gray-500 italic">Interactive WebGL Examination</p>
      </div>

      <div class="glass-panel px-6 py-4 flex-1 md:min-w-[350px] flex flex-col justify-between">
        <div class="w-full text-right mb-2">
            <h2 class="font-bold text-gray-900 text-lg md:text-xl leading-tight break-words">
                {{ $patientName }}
            </h2>
        </div>
        <div class="flex justify-between items-end w-full mt-auto">
          <span class="text-xs font-bold uppercase tracking-widest text-red-600 pr-4">Patient</span>
          <div class="text-right flex-shrink-0">
            <p class="text-xs font-bold text-[#8B0000] leading-none mb-1">{{ $currentTime }}</p>
            <p class="text-[10px] font-semibold text-gray-500 leading-none">{{ $today }}</p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
    
    <div class="xl:col-span-8 glass-panel p-4 flex flex-col items-center">
      <div class="w-full flex justify-between items-center mb-2 px-4">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest"><i class="fa-solid fa-arrows-rotate"></i> Drag to rotate • Scroll to zoom</p>
        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-full border border-gray-100 shadow-inner">
            <i class="fa-solid fa-tooth text-[#8B0000]"></i>
            <p id="toothHoverLabel" class="text-sm font-extrabold text-[#8B0000]">Select a tooth</p>
        </div>
      </div>
      
      <div id="canvas-container" class="bg-[#F1F5F9] border border-gray-200 shadow-inner rounded-xl">
          <div id="loadingOverlay" class="absolute inset-0 bg-white flex flex-col gap-3 items-center justify-center z-10 rounded-xl transition-opacity duration-500">
              <i class="fa-solid fa-circle-notch fa-spin text-4xl text-[#8B0000]"></i>
              <p class="text-sm font-semibold text-gray-600">Generating 3D Model...</p>
          </div>
      </div>
    </div>

    <div class="xl:col-span-4 glass-panel p-6 flex flex-col h-full">
      
      <div class="flex-1 space-y-6">
        
        <div>
           <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Selected Tooth</label>
           <input type="text" id="selectedToothInput" class="w-full bg-red-50/50 border border-red-100 text-[#8B0000] font-bold rounded-xl px-4 py-3 focus:outline-none" placeholder="Click a tooth on the 3D model" readonly>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Treatment</label>
          <div class="flex flex-wrap gap-2">
            @foreach(['Filling', 'Extraction', 'Cleaning', 'Root Canal', 'Crown', 'Whitening', 'Sealant', 'Braces'] as $tag)
              <button class="px-3 py-1.5 border border-yellow-300 text-yellow-800 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-xs font-bold transition">
                {{ $tag }}
              </button>
            @endforeach
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Oral Examination Notes</label>
          <textarea rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm focus:ring-2 focus:ring-[#8B0000] focus:border-[#8B0000] resize-none transition" placeholder="Add examination notes here..."></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Diagnosis</label>
          <textarea rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm focus:ring-2 focus:ring-[#8B0000] focus:border-[#8B0000] resize-none transition" placeholder="Add diagnosis here..."></textarea>
        </div>
      </div>

      <div class="pt-6 mt-4 border-t border-gray-100 space-y-3">
        <button class="w-full flex justify-center items-center gap-2 bg-[#8B0000] hover:bg-[#660000] text-white font-bold py-3.5 rounded-xl transition shadow-md">
          <i class="fa-solid fa-check"></i> Finish Procedure
        </button>
      </div>

    </div>

  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    
    const container = document.getElementById('canvas-container');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const width = container.clientWidth;
    const height = container.clientHeight;

    // 1. SETUP SCENE & CAMERA
    const scene = new THREE.Scene();
    scene.background = new THREE.Color('#F1F5F9');

    const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
    camera.position.set(0, 10, 14);

    // 2. SETUP RENDERER
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(width, height);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    container.appendChild(renderer.domElement);

    // 3. ADD CONTROLS
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.07;
    controls.minDistance = 5;
    controls.maxDistance = 30;
    controls.maxPolarAngle = Math.PI / 1.8;

    // 4. LIGHTING
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);

    const keyLight = new THREE.DirectionalLight(0xffffff, 0.7);
    keyLight.position.set(10, 15, 10);
    keyLight.castShadow = true;
    keyLight.shadow.mapSize.width = 1024;
    keyLight.shadow.mapSize.height = 1024;
    scene.add(keyLight);

    const backLight = new THREE.DirectionalLight(0xffffff, 0.4);
    backLight.position.set(-10, 5, -10);
    scene.add(backLight);

    // 5. CREATE 3D TEETH
    const teethMeshes = [];
    const toothGeometry = new THREE.CylinderGeometry(0.38, 0.22, 1.0, 32, 1);
    
    const enamelMaterialProps = {
        color: 0xFFFFF0,
        metalness: 0.1,
        roughness: 0.25,
        emissive: 0x111111,
        envMapIntensity: 1.0
    };
    
    const adultUpperTeethNums = [18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28];
    const adultLowerTeethNums = [48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38];

    function createArch(teethArray, yPosition) {
        const group = new THREE.Group();

        teethArray.forEach((toothNum, i) => {
            const material = new THREE.MeshStandardMaterial(enamelMaterialProps);
            const mesh = new THREE.Mesh(toothGeometry, material);
            mesh.castShadow = true;
            mesh.receiveShadow = true;

            let angle = Math.PI - (i / (teethArray.length - 1)) * Math.PI;
            
            let x = Math.cos(angle) * 4.0;
            let z = Math.sin(angle) * 3.5;

            mesh.position.set(x, yPosition, z);
            mesh.lookAt(0, yPosition, 0);

            mesh.userData = { tooth: toothNum, originalColor: 0xFFFFF0 };
            
            group.add(mesh);
            teethMeshes.push(mesh);
        });
        scene.add(group);
    }

    createArch(adultUpperTeethNums, 0.6);
    createArch(adultLowerTeethNums, -0.6);

    // Gums
    const gumGeometry = new THREE.TorusGeometry(3.9, 0.5, 12, 50, Math.PI);
    const gumMaterial = new THREE.MeshStandardMaterial({ 
        color: 0xF5B7B1,
        roughness: 0.8,
        metalness: 0.0 
    }); 
    
    const upperGums = new THREE.Mesh(gumGeometry, gumMaterial);
    upperGums.rotation.x = Math.PI / 2;
    upperGums.position.set(0, 1.1, 0);
    upperGums.receiveShadow = true;
    scene.add(upperGums);

    const lowerGums = new THREE.Mesh(gumGeometry, gumMaterial);
    lowerGums.rotation.x = Math.PI / 2;
    lowerGums.position.set(0, -1.1, 0);
    lowerGums.receiveShadow = true;
    scene.add(lowerGums);

    // 6. RAYCASTER
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();

    container.addEventListener('pointerdown', (event) => {
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        
        const intersects = raycaster.intersectObjects(teethMeshes);

        if (intersects.length > 0) {
            const clickedObject = intersects[0].object;

            teethMeshes.forEach(m => m.material.color.setHex(m.userData.originalColor));
            
            clickedObject.material.color.setHex(0x8B0000); 
            
            const selectedNum = clickedObject.userData.tooth;
            document.getElementById('selectedToothInput').value = `Tooth #${selectedNum}`;
            document.getElementById('toothHoverLabel').innerText = `Selected: #${selectedNum}`;
        }
    });

    window.addEventListener('resize', () => {
        const newWidth = container.clientWidth;
        const newHeight = container.clientHeight;
        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(newWidth, newHeight);
    });

    // 7. ANIMATION LOOP
    function animate() {
        requestAnimationFrame(animate);
        controls.update(); 
        renderer.render(scene, camera);
    }
    animate();

    setTimeout(() => {
        loadingOverlay.style.opacity = '0';
        setTimeout(() => loadingOverlay.style.display = 'none', 500);
    }, 1000);

  });
</script>
@endsection