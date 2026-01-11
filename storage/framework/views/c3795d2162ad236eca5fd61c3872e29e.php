<?php $__env->startSection('title', 'Editar Cliente'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Cliente</h3>
            </div>

            <form action="<?php echo e(route('clients.update', $client)); ?>"
                  method="POST"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Primer nombre</label>
                        <input type="text"
                               name="first_name"
                               class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('first_name', $client->first_name)); ?>">
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text"
                               name="last_name"
                               class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('last_name', $client->last_name)); ?>">
                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="form-group">
                        <label>Cédula de identidad</label>
                        <input type="text"
                               name="document"
                               class="form-control <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('document', $client->document)); ?>">
                        <?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="form-group">
                        <label>Copia de cédula</label>
                        <input type="file" name="id_copy" class="form-control">

                        <?php if($client->id_copy_path): ?>
                            <small class="form-text text-muted">
                                Archivo actual:
                                <a href="<?php echo e(asset('storage/' . $client->id_copy_path)); ?>" target="_blank">
                                    Ver copia
                                </a>
                            </small>
                        <?php endif; ?>

                        <?php $__errorArgs = ['id_copy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="<?php echo e(old('phone', $client->phone)); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="<?php echo e(old('email', $client->email)); ?>">
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text"
                               name="address"
                               class="form-control"
                               value="<?php echo e(old('address', $client->address)); ?>">
                    </div>

                     <div class="form-group">
                        <label>Numero de referencia</label>
                        <input type="text" name="reference_number" class="form-control" value="<?php echo e(old('reference_number', $client->reference_number)); ?>">
                    </div>

                    
                    <div class="form-group">
                        <label>Tipo de cliente</label>
                        <select name="client_type"
                                class="form-control <?php $__errorArgs = ['client_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">-- Seleccione --</option>

                            <option value="owner"
                                <?php echo e(old('client_type', $client->client_type) == 'owner' ? 'selected' : ''); ?>>
                                Dueño del vehículo
                            </option>

                            <option value="third"
                                <?php echo e(old('client_type', $client->client_type) == 'third' ? 'selected' : ''); ?>>
                                Tercero (No propietario)
                            </option>
                            <option value="insurance"
                                <?php echo e(old('client_type', $client->client_type) == 'insurance' ? 'selected' : ''); ?>>
                                Aseguradora
                            </option>
                        </select>

                        <?php $__errorArgs = ['client_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="form-group">
                        <label>Descripción / Observaciones</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"><?php echo e(old('description', $client->description)); ?></textarea>
                    </div>

                </div>

                
                <div class="card-footer">
                    <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Actualizar Cliente
                    </button>
                </div>

            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/clients/edit.blade.php ENDPATH**/ ?>